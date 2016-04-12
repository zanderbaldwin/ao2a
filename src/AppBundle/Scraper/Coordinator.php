<?php

namespace AppBundle\Scraper;

use AppBundle\Scraper\EntityScraperInterface;
use AppBundle\Scraper\Result\Collection as ResultCollection;
use Darsyn\ClassFinder\ClassFinderInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

class Coordinator
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Darsyn\ClassFinder\ClassFinderInterface
     */
    private $classFinder;

    /**
     * @var \AppBundle\Scraper\RemoteDom
     */
    private $remoteDomService;

    /**
     * @param  \Doctrine\ORM\EntityManager $entityManager
     * @param  \Darsyn\ClassFinder\ClassFinderInterface $classFinder
     * @param  \AppBundle\Scraper\RemoteDom
     */
    public function __construct(
        EntityManager $entityManager,
        ClassFinderInterface $classFinder,
        RemoteDom $remoteDomService
    ) {
        $this->em = $entityManager;
        $this->classFinder = $classFinder;
        $this->remoteDomService = $remoteDomService;

        $this->classFinder->setRootDirectory(__DIR__);
        $this->classFinder->setRootNamespace(__NAMESPACE__);
    }

    protected function loadEntityScrapers()
    {
        $scrapers = $this->classFinder->findClassReflections(null, null, 'AppBundle\Scraper\EntityScraperInterface', 1);
        $entityManager = $this->em;
        return array_map(function (\ReflectionClass $scraper) use ($entityManager) {
            return $scraper->newInstance($entityManager);
        }, $scrapers);
    }

    protected function orderEntityScrapers(array &$scrapers)
    {
        usort($scrapers, function (EntityScraperInterface $a, EntityScraperInterface $b) {
            if ($a->getOrder() == $b->getOrder()) {
                return 0;
            }
            return $a->getOrder() < $b->getOrder() ? -1 : 1;
        });
        return $scrapers;
    }

    public function run()
    {
        $entityScrapers = $this->loadEntityScrapers();
        $this->orderEntityScrapers($entityScrapers);
        foreach ($entityScrapers as $entityScraper) {
            $this->runEntityScraper($entityScraper);
        }
    }

    protected function runEntityScraper(EntityScraperInterface $scraper)
    {
        $entities = new ResultCollection;
        foreach ($scraper->getCrawlLocations() as $crawlLocation => $parentEntity) {
            try {
                $dom = $this->remoteDomService->createDomFromRemoteLocation($crawlLocation);
                do {
                    foreach ($scraper->extractEntitiesFromDom($dom, $parentEntity) as $entity) {
                        $this->em->persist($entity);
                    }
                    $this->em->flush();
                } while ($dom = $this->getDomOfNextPage($scraper, $dom));
            } catch (\Exception $e) {
                continue;
            }
        }
        return $entities;
    }

    protected function getDomOfNextPage(EntityScraperInterface $scraper, Crawler $currentPageDom)
    {
        return $this->remoteDomService->createDomFromRemoteLocation(
            $scraper->getNextPageLocation($currentPageDom)
        );
    }
}
