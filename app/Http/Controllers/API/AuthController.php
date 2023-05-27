<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Http\Resources\UserResource;

class AuthController extends BaseController
{
    /**
     * @var User
     */
    protected $userModel;
    
    public function __construct(User $userModel)
    {
        $this->user_model = $userModel;
    }

    /**
     * User Login with Email
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginWithEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->first(), 400);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $authUser = Auth::user(); 
            $userToken =  $authUser->createToken('OpenWebAuth')->plainTextToken;
            $success =  new UserResource($authUser,$userToken);
   
            return $this->sendResponse($success, 'User signed in');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    /**
     * Create New User
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }
        $user = new $this->user_model();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            $userToken =  $user->createToken('OpenWebAuth')->plainTextToken;
            $success =  new UserResource($user,$userToken);
            return $this->sendResponse($success, 'User created successfully.');    
            return $this->sendResponse($return, trans('messages.account_created_b2c', ['EMAIL' => $request->email]));
        }
        return $this->sendError('Something went wrong', '', 400);     
    }
}
