<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class inventoryApiTest extends TestCase
{
    use MakeinventoryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateinventory()
    {
        $inventory = $this->fakeinventoryData();
        $this->json('POST', '/api/v1/inventories', $inventory);

        $this->assertApiResponse($inventory);
    }

    /**
     * @test
     */
    public function testReadinventory()
    {
        $inventory = $this->makeinventory();
        $this->json('GET', '/api/v1/inventories/'.$inventory->id);

        $this->assertApiResponse($inventory->toArray());
    }

    /**
     * @test
     */
    public function testUpdateinventory()
    {
        $inventory = $this->makeinventory();
        $editedinventory = $this->fakeinventoryData();

        $this->json('PUT', '/api/v1/inventories/'.$inventory->id, $editedinventory);

        $this->assertApiResponse($editedinventory);
    }

    /**
     * @test
     */
    public function testDeleteinventory()
    {
        $inventory = $this->makeinventory();
        $this->json('DELETE', '/api/v1/inventories/'.$inventory->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/inventories/'.$inventory->id);

        $this->assertResponseStatus(404);
    }
}
