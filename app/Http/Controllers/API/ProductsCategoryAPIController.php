<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductsCategoryAPIRequest;
use App\Http\Requests\API\UpdateProductsCategoryAPIRequest;
use App\Models\product;
use App\Models\ProductsCategory;
use App\Repositories\ProductsCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ProductsCategoryController
 * @package App\Http\Controllers\API
 */

class ProductsCategoryAPIController extends AppBaseController
{
    /** @var  ProductsCategoryRepository */
    private $productsCategoryRepository;

    public function __construct(ProductsCategoryRepository $productsCategoryRepo)
    {
        $this->productsCategoryRepository = $productsCategoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/productsCategories",
     *      summary="Get a listing of the ProductsCategories.",
     *      tags={"ProductsCategory"},
     *      description="Get all ProductsCategories",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/ProductsCategory")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->productsCategoryRepository->pushCriteria(new RequestCriteria($request));
        $this->productsCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $productsCategories = $this->productsCategoryRepository->all();

        return $this->sendResponse($productsCategories->toArray(), 'Products Categories retrieved successfully');
    }

    /**
     * @param CreateProductsCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/productsCategories",
     *      summary="Store a newly created ProductsCategory in storage",
     *      tags={"ProductsCategory"},
     *      description="Store ProductsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProductsCategory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProductsCategory")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ProductsCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductsCategoryAPIRequest $request)
    {
        $input = $request->all();

        $productsCategories = $this->productsCategoryRepository->create($input);

        return $this->sendResponse($productsCategories->toArray(), 'Products Category saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/productsCategories/{id}",
     *      summary="Display the specified ProductsCategory",
     *      tags={"ProductsCategory"},
     *      description="Get ProductsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductsCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ProductsCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var ProductsCategory $productsCategory */
        $productsCategory = $this->productsCategoryRepository->findWithoutFail($id);

        if (empty($productsCategory)) {
            return $this->sendError('Products Category not found');
        }

        return $this->sendResponse($productsCategory->toArray(), 'Products Category retrieved successfully');
    }




      /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/productsByCategory/{id}",
     *      summary="Display all products by category id",
     *      tags={"ProductsCategory"},
     *      description="Get products by category id",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductsCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ProductsCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function productsByCategory($id)
    {
        /** @var ProductsCategory $productsCategory */
        $productsCategory = product::where('product_category_id',$id)->get();

        if (empty($productsCategory)) {
            return $this->sendError('Products Categories not found');
        }

        return $this->sendResponse($productsCategory->toArray(), 'Products Categories retrieved successfully');
    }




    /**
     * @param int $id
     * @param UpdateProductsCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/productsCategories/{id}",
     *      summary="Update the specified ProductsCategory in storage",
     *      tags={"ProductsCategory"},
     *      description="Update ProductsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductsCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProductsCategory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProductsCategory")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ProductsCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductsCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var ProductsCategory $productsCategory */
        $productsCategory = $this->productsCategoryRepository->findWithoutFail($id);

        if (empty($productsCategory)) {
            return $this->sendError('Products Category not found');
        }

        $productsCategory = $this->productsCategoryRepository->update($input, $id);

        return $this->sendResponse($productsCategory->toArray(), 'ProductsCategory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/productsCategories/{id}",
     *      summary="Remove the specified ProductsCategory from storage",
     *      tags={"ProductsCategory"},
     *      description="Delete ProductsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductsCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var ProductsCategory $productsCategory */
        $productsCategory = $this->productsCategoryRepository->findWithoutFail($id);

        if (empty($productsCategory)) {
            return $this->sendError('Products Category not found');
        }

        $productsCategory->delete();

        return $this->sendResponse($id, 'Products Category deleted successfully');
    }
}
