<?php

namespace AppBundle\Scraper;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractScraper implements EntityScraperInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @param  \Doctrine\ORM\EntityManager $entityManager
     * @param  \Darsyn\ClassFinder\ClassFinderInterface $classFinder
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->em;
    }

    /**
     * {@inheritDoc}
     */
    public function getNextPageLocation(Crawler $currentPageDom)
    {
        $link = $currentPageDom->filterXPath('//ol[contains(@class, "pagination")]/li[contains(@class, "next")]/a');
        if ($link->count() !== 0) {
            return $link->attr('href');
        }
    }
}
