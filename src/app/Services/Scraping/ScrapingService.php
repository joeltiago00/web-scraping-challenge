<?php

namespace App\Services\Scraping;

use App\Exceptions\Scraping\FailToMakeScrapingException;
use App\Services\Request\Contracts\RequestServiceInterface;
use App\Services\Scraping\Contracts\ScrapingServiceInterface;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingService implements ScrapingServiceInterface
{
    /**
     * @var Crawler
     */
    private readonly Crawler $crawler;

    public function __construct(
        private readonly RequestServiceInterface $client,
    ) {
        $this->crawler = new Crawler();
    }

    /**
     * @param string $url
     * @param string $filter
     * @return array
     * @throws FailToMakeScrapingException
     */
    public function search(string $url, string $filter): array
    {
        try {
            $response = $this->client->get($url);

            $html = $response->getHTML();

            $this->crawler->addHtmlContent($html);

            $html_elements = $this->crawler->filter($filter);

            foreach ($html_elements as $element) {
                $elements[] = $element->textContent;
            }
        } catch (\Exception $exception) {
            throw new FailToMakeScrapingException($exception);
        }

        return $elements ?? [];
    }
}


