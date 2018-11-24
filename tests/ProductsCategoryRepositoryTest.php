<?php

use App\Models\ProductsCategory;
use App\Repositories\ProductsCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsCategoryRepositoryTest extends TestCase
{
    use MakeProductsCategoryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProductsCategoryRepository
     */
    protected $productsCategoryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->productsCategoryRepo = App::make(ProductsCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateProductsCategory()
    {
        $productsCategory = $this->fakeProductsCategoryData();
        $createdProductsCategory = $this->productsCategoryRepo->create($productsCategory);
        $createdProductsCategory = $createdProductsCategory->toArray();
        $this->assertArrayHasKey('id', $createdProductsCategory);
        $this->assertNotNull($createdProductsCategory['id'], 'Created ProductsCategory must have id specified');
        $this->assertNotNull(ProductsCategory::find($createdProductsCategory['id']), 'ProductsCategory with given id must be in DB');
        $this->assertModelData($productsCategory, $createdProductsCategory);
    }

    /**
     * @test read
     */
    public function testReadProductsCategory()
    {
        $productsCategory = $this->makeProductsCategory();
        $dbProductsCategory = $this->productsCategoryRepo->find($productsCategory->id);
        $dbProductsCategory = $dbProductsCategory->toArray();
        $this->assertModelData($productsCategory->toArray(), $dbProductsCategory);
    }

    /**
     * @test update
     */
    public function testUpdateProductsCategory()
    {
        $productsCategory = $this->makeProductsCategory();
        $fakeProductsCategory = $this->fakeProductsCategoryData();
        $updatedProductsCategory = $this->productsCategoryRepo->update($fakeProductsCategory, $productsCategory->id);
        $this->assertModelData($fakeProductsCategory, $updatedProductsCategory->toArray());
        $dbProductsCategory = $this->productsCategoryRepo->find($productsCategory->id);
        $this->assertModelData($fakeProductsCategory, $dbProductsCategory->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteProductsCategory()
    {
        $productsCategory = $this->makeProductsCategory();
        $resp = $this->productsCategoryRepo->delete($productsCategory->id);
        $this->assertTrue($resp);
        $this->assertNull(ProductsCategory::find($productsCategory->id), 'ProductsCategory should not exist in DB');
    }
}
