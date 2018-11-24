<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class productApiTest extends TestCase
{
    use MakeproductTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateproduct()
    {
        $product = $this->fakeproductData();
        $this->json('POST', '/api/v1/products', $product);

        $this->assertApiResponse($product);
    }

    /**
     * @test
     */
    public function testReadproduct()
    {
        $product = $this->makeproduct();
        $this->json('GET', '/api/v1/products/'.$product->id);

        $this->assertApiResponse($product->toArray());
    }

    /**
     * @test
     */
    public function testUpdateproduct()
    {
        $product = $this->makeproduct();
        $editedproduct = $this->fakeproductData();

        $this->json('PUT', '/api/v1/products/'.$product->id, $editedproduct);

        $this->assertApiResponse($editedproduct);
    }

    /**
     * @test
     */
    public function testDeleteproduct()
    {
        $product = $this->makeproduct();
        $this->json('DELETE', '/api/v1/products/'.$product->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/products/'.$product->id);

        $this->assertResponseStatus(404);
    }
}
