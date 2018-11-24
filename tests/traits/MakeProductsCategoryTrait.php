<?php

use Faker\Factory as Faker;
use App\Models\ProductsCategory;
use App\Repositories\ProductsCategoryRepository;

trait MakeProductsCategoryTrait
{
    /**
     * Create fake instance of ProductsCategory and save it in database
     *
     * @param array $productsCategoryFields
     * @return ProductsCategory
     */
    public function makeProductsCategory($productsCategoryFields = [])
    {
        /** @var ProductsCategoryRepository $productsCategoryRepo */
        $productsCategoryRepo = App::make(ProductsCategoryRepository::class);
        $theme = $this->fakeProductsCategoryData($productsCategoryFields);
        return $productsCategoryRepo->create($theme);
    }

    /**
     * Get fake instance of ProductsCategory
     *
     * @param array $productsCategoryFields
     * @return ProductsCategory
     */
    public function fakeProductsCategory($productsCategoryFields = [])
    {
        return new ProductsCategory($this->fakeProductsCategoryData($productsCategoryFields));
    }

    /**
     * Get fake data of ProductsCategory
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProductsCategoryData($productsCategoryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'category_name' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $productsCategoryFields);
    }
}
