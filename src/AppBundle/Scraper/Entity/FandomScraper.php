<?php

namespace AppBundle\Scraper\Entity;

use AppBundle\Entity\Fandom;
use AppBundle\Entity\Media;
use AppBundle\Scraper\AbstractScraper;
use AppBundle\Scraper\Result\Collection as ResultCollection;
use Symfony\Component\DomCrawler\Crawler;

class FandomScraper extends AbstractScraper
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * {@inheritDoc}
     */
    public function getCrawlLocations()
    {
        foreach ($this->getEntityManager()->getRepository(Media::class)->findAll() as $media) {
            yield sprintf('http://archiveofourown.org/media/%s/fandoms', $media->getSlug()) => $media;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function extractEntitiesFromDom(Crawler $dom, $parentEntity = null)
    {
        $nodes = $dom->filterXPath('//ol[contains(@class, "fandom")]//li[contains(@class, "letter")]//a[contains(@class, "tag")]');
        foreach ($nodes as $node) {
            yield $this->populateEntityFromNode($node, $parentEntity);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function populateEntityFromNode(Crawler $node, $parentEntity = null)
    {
        $entity = new Fandom;
        $entity->setName($node->text());
        preg_match('#tags/([^/]+)/works#', $node->attr('href'), $matches);
        $entity->setSlug($matches[1]);
        $parentEntity instanceof Media && $entity->setMedia($media);
        return $entity;
    }
}
