<?php

use App\Models\product;
use App\Repositories\productRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class productRepositoryTest extends TestCase
{
    use MakeproductTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var productRepository
     */
    protected $productRepo;

    public function setUp()
    {
        parent::setUp();
        $this->productRepo = App::make(productRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateproduct()
    {
        $product = $this->fakeproductData();
        $createdproduct = $this->productRepo->create($product);
        $createdproduct = $createdproduct->toArray();
        $this->assertArrayHasKey('id', $createdproduct);
        $this->assertNotNull($createdproduct['id'], 'Created product must have id specified');
        $this->assertNotNull(product::find($createdproduct['id']), 'product with given id must be in DB');
        $this->assertModelData($product, $createdproduct);
    }

    /**
     * @test read
     */
    public function testReadproduct()
    {
        $product = $this->makeproduct();
        $dbproduct = $this->productRepo->find($product->id);
        $dbproduct = $dbproduct->toArray();
        $this->assertModelData($product->toArray(), $dbproduct);
    }

    /**
     * @test update
     */
    public function testUpdateproduct()
    {
        $product = $this->makeproduct();
        $fakeproduct = $this->fakeproductData();
        $updatedproduct = $this->productRepo->update($fakeproduct, $product->id);
        $this->assertModelData($fakeproduct, $updatedproduct->toArray());
        $dbproduct = $this->productRepo->find($product->id);
        $this->assertModelData($fakeproduct, $dbproduct->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteproduct()
    {
        $product = $this->makeproduct();
        $resp = $this->productRepo->delete($product->id);
        $this->assertTrue($resp);
        $this->assertNull(product::find($product->id), 'product should not exist in DB');
    }
}
