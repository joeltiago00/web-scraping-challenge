<?php

namespace App\Services\OpenFoodFactsScraping;

use App\Exceptions\Scraping\FailToGetBarcodeException;
use App\Exceptions\Scraping\FailToGetCategoriesException;
use App\Exceptions\Scraping\FailToGetCodeException;
use App\Exceptions\Scraping\FailToGetNameException;
use App\Exceptions\Scraping\FailToMakeScrapingException;
use App\Services\OpenFoodFactsScraping\Contracts\OpenFoodFactsProductInterface;
use App\Services\Request\Contracts\RequestServiceInterface;
use App\Services\OpenFoodFactsScraping\Contracts\OpenFoodFactsScrapingServiceInterface;
use Symfony\Component\DomCrawler\Crawler;

class OpenFoodFactsScrapingService implements OpenFoodFactsScrapingServiceInterface
{
    /**
     * @var Crawler
     */
    private readonly Crawler $crawler;
    /**
     * @var string
     */
    private readonly string $openFoodFactsUri;

    /**
     * @param RequestServiceInterface $client
     */
    public function __construct(
        private readonly RequestServiceInterface $client,
    )
    {
        $this->crawler = new Crawler();
        $this->openFoodFactsUri = config('app.integration.open_food_facts.url');
    }

    /**
     * @return array
     * @throws FailToMakeScrapingException
     */
    public function getProductsLinks(): array
    {
        try {
            $response = $this->client->get($this->openFoodFactsUri);

            $html = $response->getHTML();

            $this->crawler->addHtmlContent($html);

            return $this->crawler
                ->filter('#search_results li a')
                ->each(function (Crawler $node) {
                    return $node->attr('href');
                });
        } catch (\Exception $exception) {
            throw new FailToMakeScrapingException($exception);
        }
    }

    /**
     * @param string $uri
     * @return OpenFoodFactsProductInterface
     * @throws FailToGetBarcodeException
     * @throws FailToGetCategoriesException
     * @throws FailToGetCodeException
     * @throws FailToGetNameException
     */
    public function getProductInfo(string $uri): OpenFoodFactsProductInterface
    {
        $url = sprintf('%s%s', $this->openFoodFactsUri, $uri);

        $response = $this->client->get($url);

        $html = $response->getHTML();

        $barcode = $this->getProductBarcode($html);

        $code = $this->getProductCode($barcode);

        $name = $this->getProductName($html);

        $quantity = $this->getProductQuantity($html);

        $categories = $this->getProductCategories($html);

        $packaging = $this->getProductPackaging($html);

        $brands = $this->getProductBrands($html);

        $image_url = $this->getProductImageUrl($code);

        return new OpenFoodFactsProduct(
            $code, $barcode, $url, $name, $quantity, $categories, $packaging, $brands, $image_url
        );
    }

    /**
     * @param string $html
     * @return string
     * @throws FailToGetBarcodeException
     */
    public function getProductBarcode(string $html): string
    {
        $this->crawler->clear();

        $this->crawler->addHtmlContent($html);

        $barcode = $this->crawler
            ->filter('#barcode_paragraph')
            ->text();

        $barcode = explode(':', $barcode);

        if (!isset($barcode[1]))
            throw new FailToGetBarcodeException();

        return trim($barcode[1]);
    }

    /**
     * @param string $barcode
     * @return string
     * @throws FailToGetCodeException
     */
    private function getProductCode(string $barcode): string
    {
        $barcode = explode('(', $barcode);

        if (!isset($barcode[0]))
            throw new FailToGetCodeException();

        return trim($barcode[0]);
    }

    /**
     * @param string $html
     * @return string
     * @throws FailToGetNameException
     */
    private function getProductName(string $html): string
    {
        $this->crawler->clear();

        $this->crawler->addHtmlContent($html);

        $name = $this->crawler
            ->filter('#main_column > div:nth-child(4) > h1')
            ->text();

        $name = explode('-', $name);

        if (!isset($name[0]))
            throw new FailToGetNameException();

        return trim($name[0]);
    }

    /**
     * @param string $html
     * @return string
     */
    private function getProductQuantity(string $html): string
    {
        $this->crawler->clear();

        $this->crawler->addHtmlContent($html);

        try {
            $quantity = $this->crawler
                ->filter('#field_quantity_value')
                ->text();
        } catch (\Exception) {
            return '';
        }


        return $quantity;
    }

    /**
     * @param string $html
     * @return string
     * @throws FailToGetCategoriesException
     */
    private function getProductCategories(string $html): string
    {
        $this->crawler->clear();

        $this->crawler->addHtmlContent($html);

        $categories = $this->crawler
            ->filter('#field_categories')
            ->text();

        if (empty($categories))
            throw new FailToGetCategoriesException();

        $categories = str_replace('Categories: ', '', $categories);

        $categories = str_replace(' and ', ', ', $categories);

        return ucwords($categories);
    }

    /**
     * @param string $html
     * @return string
     */
    private function getProductPackaging(string $html): string
    {
        $this->crawler->clear();

        $this->crawler->addHtmlContent($html);

        try {
            return $this->crawler
                ->filter('#field_packaging_value')
                ->text();
        } catch (\Exception) {
            return '';
        }
    }

    /**
     * @param string $html
     * @return string
     */
    private function getProductBrands(string $html): string
    {
        $this->crawler->clear();

        $this->crawler->addHtmlContent($html);

        try {
            return $this->crawler
                ->filter('#field_brands_value')
                ->text();
        } catch (\Exception) {
            return '';
        }
    }

    private function getProductImageUrl(string $barcode): string
    {
        $response = $this->client->get("https://world.openfoodfacts.org/api/v0/product/$barcode.json");

        $product = $response->getBody();

        return $product['product']['image_url'] ?? '';
    }
}


