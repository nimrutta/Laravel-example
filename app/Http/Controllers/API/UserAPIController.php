<?php

namespace App\Http\Controllers\API;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Response;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */


class UserAPIController extends AppBaseController
{

    /**
     * @param CreateUserAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/users",
     *      summary="Store a newly created User in storage",
     *      tags={"User"},
     *      description="Store User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be stored",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/User")
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

   public function signup(Request $request){
       $this->validate($request, [
           'name' => 'required',
           'email' => 'required|email|unique:users',
           'password' => 'required'
       ]);

       $user = new User([
           'name' => $request->input('name'),
           'email' => $request->input('email'),
           'password' => bcrypt($request->input('password')),
       ]);

       $user->save();
       return response()->json([
           'message' => 'Succesfully created user!'
       ], 201);
   }


     /**
     * @param SigninUserAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/signin",
     *      summary="Signin a user",
     *      tags={"User"},
     *      description="Signin a user",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User to be authenticated",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/User")
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */


    public function signin(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password'); 

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'invalid credentials!'
                ], 401);
            }
   
        } catch (JWTException $e) {
                return response()->json([
                    'error' => 'Could not create token'
                ], 500);
        }

        return response()-> json([ 'token' => $token] ,200);

    }

}
