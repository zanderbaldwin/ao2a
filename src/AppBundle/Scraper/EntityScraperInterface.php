<?php

namespace AppBundle\Scraper;

use Symfony\Component\DomCrawler\Crawler;
use Doctrine\ORM\EntityManager;

interface EntityScraperInterface
{
    /**
     * @return integer
     */
    public function getOrder();

    /**
     * @return array<string>
     */
    public function getCrawlLocations();

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler $currentPageDom
     * @return string
     */
    public function getNextPageLocation(Crawler $currentPageDom);

    /**
     * @return \AppBundle\Scraper\Result\Collection
     */
    public function extractEntitiesFromDom(Crawler $dom, $parentEntity = null);

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler $entityNode
     * @param  object $parentEntity
     * @return object
     */
    public function populateEntityFromNode(Crawler $entityNode, $parentEntity = null);
}
