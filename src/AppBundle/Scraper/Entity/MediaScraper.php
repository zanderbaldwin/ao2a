<?php

namespace AppBundle\Scraper\Entity;

use AppBundle\Entity\Media;
use AppBundle\Scraper\AbstractScraper;
use AppBundle\Scraper\Result\Collection as ResultCollection;
use Symfony\Component\DomCrawler\Crawler;

class MediaScraper extends AbstractScraper
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * {@inheritDoc}
     */
    public function getCrawlLocations()
    {
        return [
            'http://archiveofourown.org/media' => null,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function extractEntitiesFromDom(Crawler $dom, $parentEntity = null)
    {
        $results = new ResultCollection;
        $nodes = $dom->filterXPath('//li[contains(@class, "medium")]//h3[contains(@class, "heading")]//a');
        $nodes->each(function (Crawler $node) use ($results) {
            $results->attach($this->populateEntityFromNode($node));
        });
        return $results;
    }

    /**
     * {@inheritDoc}
     */
    public function populateEntityFromNode(Crawler $node, $parentEntity = null)
    {
        $entity = new Media;
        $entity->setName($node->text());
        preg_match('#media/([^/]+)/fandoms#', $node->attr('href'), $matches);
        $entity->setSlug($matches[1]);
        return $entity;
    }
}
