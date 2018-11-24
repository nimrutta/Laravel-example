<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsCategoryApiTest extends TestCase
{
    use MakeProductsCategoryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateProductsCategory()
    {
        $productsCategory = $this->fakeProductsCategoryData();
        $this->json('POST', '/api/v1/productsCategories', $productsCategory);

        $this->assertApiResponse($productsCategory);
    }

    /**
     * @test
     */
    public function testReadProductsCategory()
    {
        $productsCategory = $this->makeProductsCategory();
        $this->json('GET', '/api/v1/productsCategories/'.$productsCategory->id);

        $this->assertApiResponse($productsCategory->toArray());
    }

    /**
     * @test
     */
    public function testUpdateProductsCategory()
    {
        $productsCategory = $this->makeProductsCategory();
        $editedProductsCategory = $this->fakeProductsCategoryData();

        $this->json('PUT', '/api/v1/productsCategories/'.$productsCategory->id, $editedProductsCategory);

        $this->assertApiResponse($editedProductsCategory);
    }

    /**
     * @test
     */
    public function testDeleteProductsCategory()
    {
        $productsCategory = $this->makeProductsCategory();
        $this->json('DELETE', '/api/v1/productsCategories/'.$productsCategory->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/productsCategories/'.$productsCategory->id);

        $this->assertResponseStatus(404);
    }
}
