<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateinventoryAPIRequest;
use App\Http\Requests\API\UpdateinventoryAPIRequest;
use App\Models\inventory;
use App\Repositories\inventoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class inventoryController
 * @package App\Http\Controllers\API
 */

class inventoryAPIController extends AppBaseController
{
    /** @var  inventoryRepository */
    private $inventoryRepository;

    public function __construct(inventoryRepository $inventoryRepo)
    {
        $this->inventoryRepository = $inventoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/inventories",
     *      summary="Get a listing of the inventories.",
     *      tags={"inventory"},
     *      description="Get all inventories",
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
     *                  @SWG\Items(ref="#/definitions/inventory")
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
        $this->inventoryRepository->pushCriteria(new RequestCriteria($request));
        $this->inventoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $inventories = $this->inventoryRepository->all();

        return $this->sendResponse($inventories->toArray(), 'Inventories retrieved successfully');
    }

    /**
     * @param CreateinventoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/inventories",
     *      summary="Store a newly created inventory in storage",
     *      tags={"inventory"},
     *      description="Store inventory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="inventory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/inventory")
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
     *                  ref="#/definitions/inventory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateinventoryAPIRequest $request)
    {
        $input = $request->all();

        $inventories = $this->inventoryRepository->create($input);

        return $this->sendResponse($inventories->toArray(), 'Inventory saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/inventories/{id}",
     *      summary="Display the specified inventory",
     *      tags={"inventory"},
     *      description="Get inventory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of inventory",
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
     *                  ref="#/definitions/inventory"
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
        /** @var inventory $inventory */
        $inventory = $this->inventoryRepository->findWithoutFail($id);

        if (empty($inventory)) {
            return $this->sendError('Inventory not found');
        }

        return $this->sendResponse($inventory->toArray(), 'Inventory retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateinventoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/inventories/{id}",
     *      summary="Update the specified inventory in storage",
     *      tags={"inventory"},
     *      description="Update inventory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of inventory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="inventory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/inventory")
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
     *                  ref="#/definitions/inventory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateinventoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var inventory $inventory */
        $inventory = $this->inventoryRepository->findWithoutFail($id);

        if (empty($inventory)) {
            return $this->sendError('Inventory not found');
        }

        $inventory = $this->inventoryRepository->update($input, $id);

        return $this->sendResponse($inventory->toArray(), 'inventory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/inventories/{id}",
     *      summary="Remove the specified inventory from storage",
     *      tags={"inventory"},
     *      description="Delete inventory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of inventory",
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
        /** @var inventory $inventory */
        $inventory = $this->inventoryRepository->findWithoutFail($id);

        if (empty($inventory)) {
            return $this->sendError('Inventory not found');
        }

        $inventory->delete();

        return $this->sendResponse($id, 'Inventory deleted successfully');
    }
}
