<?php

namespace AppBundle\Scraper\Factory;

interface DomCrawlerFactoryInterface
{
    /**
     * @param  string $markup
     * @return \Symfony\Component\DomCrawler\Crawler;
     */
    public function createFromMarkup($markup);
}
