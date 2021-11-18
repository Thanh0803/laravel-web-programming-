<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Information;

class UserController extends Controller
{
    //

    public function register(Request $request)
        {
            //VALIDATION HERE

            $info = Information::create([
                'username'=>$request->username,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'role' => 1
            ]);
            if($info->id){
                $user = User::create([
                    'information_id' => $info->id,
                ]);
            }
            
            //REGISTER NEW USER BY RECORDING NAME, PHONE
            return response()->json([
                'status_code'=>200,
                'message'=>'User registered successfully.',
                'data'=>[

                ]
            ]);
        }

        public function login(Request $request)
        {
            //VALIDATE PHONE NUMBER

            $info = Information::where('username',$request->username)->first();

            if(!$info){
                return response()->json([
                    'status_code'=>404  ,
                    'message'=>'User does not exist.',
                    'data'=>[

                    ]
                ]);
            }

            if(!Hash::check($request->password,$info->password)){
                return response()->json([
                    'status_code'=>401  ,
                    'message'=>'Incorrect password',
                    'data'=>[

                    ]
                ]);
            }
            $user = User::where('information_id',$info->id)->first();
            if(!$user){
                return response()->json([
                    'status_code'=>404  ,
                    'message'=>'User does not exist.',
                    'data'=> [

                    ]
                ]);
            }
            $user->OauthAcessToken()->where('name','user')->delete();
            $access_token = $user->createToken('user',['user'])->accessToken;
            //LOGIN
            
            //RETURN DATA WITH access_TOKEN
            return response()->json([
                'status_code'=>200 ,
                'message'=>'User has successfully logged in OTP.',
                'data'=>[
                    'user'=>$user,
                    'access_token'=>$access_token
                ]
            ]);
        }

        public function logout(Request $request)
        {
            $request->user()->OauthAcessToken()->where('name','user')->delete();

            return response()->json([
                'status_code'=>200 ,
                'message'=>'Logout successful.',
                'data'=>[

                ]
            ]);
        }
}
