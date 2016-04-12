<?php

namespace AppBundle\Scraper;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use AppBundle\Scraper\Factory\DomCrawlerFactoryInterface;

class RemoteDom
{
    private $httpClient;
    private $messageFactory;
    private $domCrawlerFactory;

    public function __construct(
        HttpClient $httpClient,
        MessageFactory $messageFactory,
        DomCrawlerFactoryInterface $domCrawlerFactory
    ) {
        $this->httpClient = $httpClient;
        $this->messageFactory = $messageFactory;
        $this->domCrawlerFactory = $domCrawlerFactory;
    }

    public function createDomFromRemoteLocation($location)
    {
        $request = $this->messageFactory->createRequest('GET', $location);
        $response = $this->httpClient->sendRequest($request);
        return $this->domCrawlerFactory->createFromMarkup((string) $response->getBody());
    }
}
