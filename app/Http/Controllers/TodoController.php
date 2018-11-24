<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
     /** @var  todoRepository */
     private $todoRepository;

     public function __construct(todoRepository $todoRepo)
     {
         $this->todoRepository = $todoRepo;
     }
 
     /**
      * @param Request $request
      * @return Response
      *
      * @SWG\Get(
      *      path="/todos",
      *      summary="Get a listing of the todos.",
      *      tags={"todo"},
      *      description="Get all todos",
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
      *                  @SWG\Items(ref="#/definitions/todo")
      *              ),
      *              @SWG\Property(
      *                  property="message",
      *                  type="string"
      *              )
      *          )
      *      )
      * )
      */
     public function index()
     {
        $todo = Todo::paginate(30);

        return todoresource::collection($todo);
     }
 
     /**
      * @param CreatetodoAPIRequest $request
      * @return Response
      *
      * @SWG\Post(
      *      path="/todos",
      *      summary="Store a newly created todo in storage",
      *      tags={"todo"},
      *      description="Store todo",
      *      produces={"application/json"},
      *      @SWG\Parameter(
      *          name="body",
      *          in="body",
      *          description="todo that should be stored",
      *          required=false,
      *          @SWG\Schema(ref="#/definitions/todo")
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
      *                  ref="#/definitions/todo"
      *              ),
      *              @SWG\Property(
      *                  property="message",
      *                  type="string"
      *              )
      *          )
      *      )
      * )
      */
     public function store(CreatetodoAPIRequest $request)
     {
         $input = $request->all();
 
         $todos = $this->todoRepository->create($input);
 
         return $this->sendResponse($todos->toArray(), 'todo saved successfully');
     }
 
     /**
      * @param int $id
      * @return Response
      *
      * @SWG\Get(
      *      path="/todos/{id}",
      *      summary="Display the specified todo",
      *      tags={"todo"},
      *      description="Get todo",
      *      produces={"application/json"},
      *      @SWG\Parameter(
      *          name="id",
      *          description="id of todo",
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
      *                  ref="#/definitions/todo"
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
         /** @var todo $todo */
         $todo = $this->todoRepository->findWithoutFail($id);
 
         if (empty($todo)) {
             return $this->sendError('todo not found');
         }
 
         return $this->sendResponse($todo->toArray(), 'todo retrieved successfully');
     }
 
     /**
      * @param int $id
      * @param UpdatetodoAPIRequest $request
      * @return Response
      *
      * @SWG\Put(
      *      path="/todos/{id}",
      *      summary="Update the specified todo in storage",
      *      tags={"todo"},
      *      description="Update todo",
      *      produces={"application/json"},
      *      @SWG\Parameter(
      *          name="id",
      *          description="id of todo",
      *          type="integer",
      *          required=true,
      *          in="path"
      *      ),
      *      @SWG\Parameter(
      *          name="body",
      *          in="body",
      *          description="todo that should be updated",
      *          required=false,
      *          @SWG\Schema(ref="#/definitions/todo")
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
      *                  ref="#/definitions/todo"
      *              ),
      *              @SWG\Property(
      *                  property="message",
      *                  type="string"
      *              )
      *          )
      *      )
      * )
      */
     public function update($id, UpdatetodoAPIRequest $request)
     {
         $input = $request->all();
 
         /** @var todo $todo */
         $todo = $this->todoRepository->findWithoutFail($id);
 
         if (empty($todo)) {
             return $this->sendError('todo not found');
         }
 
         $todo = $this->todoRepository->update($input, $id);
 
         return $this->sendResponse($todo->toArray(), 'todo updated successfully');
     }
 
     /**
      * @param int $id
      * @return Response
      *
      * @SWG\Delete(
      *      path="/todos/{id}",
      *      summary="Remove the specified todo from storage",
      *      tags={"todo"},
      *      description="Delete todo",
      *      produces={"application/json"},
      *      @SWG\Parameter(
      *          name="id",
      *          description="id of todo",
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
         /** @var todo $todo */
         $todo = $this->todoRepository->findWithoutFail($id);
 
         if (empty($todo)) {
             return $this->sendError('todo not found');
         }
 
         $todo->delete();
 
         return $this->sendResponse($id, 'todo deleted successfully');
     }
}
