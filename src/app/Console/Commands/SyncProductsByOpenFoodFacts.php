<?php

namespace App\Console\Commands;

use App\Exceptions\Scraping\FailToMakeScrapingException;
use App\Mail\SyncProductErrorMail;
use App\Services\OpenFoodFactsScraping\Contracts\OpenFoodFactsProductInterface;
use App\Services\OpenFoodFactsScraping\Contracts\OpenFoodFactsScrapingServiceInterface;
use App\Services\OpenFoodFactsScraping\OpenFoodFactsScrapingService;
use App\Services\Product\ProductService;
use App\Services\Request\RequestService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SyncProductsByOpenFoodFacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:products-open-food-facts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command make integration products integration of Open Food Facts.';

    /**
     * Array of errors during syncing
     *
     * @var array
     */
    private array $errors = [];

    /**
     * @return int
     * @throws FailToMakeScrapingException
     */
    public function handle(): int
    {
        $this->info(Carbon::now() . ' -> Stating syncing products from Open Food Facts...');

        $open_food_facts_scraping = new OpenFoodFactsScrapingService(new RequestService());

        $this->info(Carbon::now() . ' -> Getting products links...');

        $this->warn(str_repeat('=', 80));

        $links = $open_food_facts_scraping->getProductsLinks();

        if (empty($links)) {
            $this->error(Carbon::now() . ' -> Error to get link of products information. Exiting...');

            die();
        }

        $this->info(Carbon::now() . ' -> Getting products info...');

        $products = $this->getProductsInfo($open_food_facts_scraping, $links);

        $this->warn(str_repeat('=', 80));

        $this->syncProducts($products);

        if (!empty($this->errors))
            Mail::to('joeltiago00745@gmail.com')->send(new SyncProductErrorMail($this->errors));

        return 1;
    }

    /**
     * @param OpenFoodFactsScrapingServiceInterface $openFoodFactsScrapingService
     * @param array $links
     * @return array
     */
    private function getProductsInfo(
        OpenFoodFactsScrapingServiceInterface $openFoodFactsScrapingService,
        array $links
    ): array
    {
        foreach ($links as $link) {
            $products[] = $openFoodFactsScrapingService->getProductInfo($link);
        }

        if (empty($products)) {
            $this->error(Carbon::now() . ' -> Error to get products information. Exiting...');

            die();
        }

        return $products;
    }

    /**
     * @param array $products
     * @return void
     */
    private function syncProducts(array $products): void
    {
        $product_service = new ProductService();

        /**
         * @var $product OpenFoodFactsProductInterface
         */
        foreach ($products as $product) {
            $this->info(Carbon::now() . ' -> Syncing product: ' . $product->getCode());

            try {
                if (!$product_service->existsByCode($product->getCode())) {
                    $this->line(Carbon::now() . ' -> Storing product...');

                    $product_service->store($product);

                    $this->line(Carbon::now() . ' -> Stored product.');
                } else {
                    $this->line(Carbon::now() . ' -> Updating product...');

                    $product_service->update($product);

                    $this->line(Carbon::now() . ' -> Updated product.');
                }
            } catch (\Exception $exception) {
                $this->errors = array_merge($this->errors, [$product->getCode() => $exception->getMessage()]);

                $this->error(Carbon::now() . ' -> Error: ' . $exception->getMessage());
            }

            $this->warn(str_repeat('=', 80));
        }
    }


}
