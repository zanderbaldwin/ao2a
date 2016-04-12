<?php

namespace AppBundle\Scraper\Factory;

use Symfony\Component\DomCrawler\Crawler;

class DomCrawlerFactory implements DomCrawlerFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createFromMarkup($markup)
    {
        $domCrawler = new Crawler;
        $domCrawler->clear();
        $domCrawler->addHtmlContent($markup);
        return $domCrawler;
    }
}
