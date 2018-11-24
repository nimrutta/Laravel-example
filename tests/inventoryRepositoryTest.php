<?php

use App\Models\inventory;
use App\Repositories\inventoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class inventoryRepositoryTest extends TestCase
{
    use MakeinventoryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var inventoryRepository
     */
    protected $inventoryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->inventoryRepo = App::make(inventoryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateinventory()
    {
        $inventory = $this->fakeinventoryData();
        $createdinventory = $this->inventoryRepo->create($inventory);
        $createdinventory = $createdinventory->toArray();
        $this->assertArrayHasKey('id', $createdinventory);
        $this->assertNotNull($createdinventory['id'], 'Created inventory must have id specified');
        $this->assertNotNull(inventory::find($createdinventory['id']), 'inventory with given id must be in DB');
        $this->assertModelData($inventory, $createdinventory);
    }

    /**
     * @test read
     */
    public function testReadinventory()
    {
        $inventory = $this->makeinventory();
        $dbinventory = $this->inventoryRepo->find($inventory->id);
        $dbinventory = $dbinventory->toArray();
        $this->assertModelData($inventory->toArray(), $dbinventory);
    }

    /**
     * @test update
     */
    public function testUpdateinventory()
    {
        $inventory = $this->makeinventory();
        $fakeinventory = $this->fakeinventoryData();
        $updatedinventory = $this->inventoryRepo->update($fakeinventory, $inventory->id);
        $this->assertModelData($fakeinventory, $updatedinventory->toArray());
        $dbinventory = $this->inventoryRepo->find($inventory->id);
        $this->assertModelData($fakeinventory, $dbinventory->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteinventory()
    {
        $inventory = $this->makeinventory();
        $resp = $this->inventoryRepo->delete($inventory->id);
        $this->assertTrue($resp);
        $this->assertNull(inventory::find($inventory->id), 'inventory should not exist in DB');
    }
}
