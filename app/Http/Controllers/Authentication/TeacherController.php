<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;
use App\Models\Account;

class TeacherController extends Controller
{
    //

    public function register(Request $request)
        {
            //VALIDATION HERE

            $info = Account::create([
                'username'=>$request->username,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'role' => 1
            ]);
            if($info->id){
                $teacher = Teacher::create([
                    'account_id' => $info->id,
                ]);
            }
            
            //REGISTER NEW USER BY RECORDING NAME, PHONE
            return response()->json([
                'status_code'=>200,
                'message'=>'Teacher registered successfully.',
                'data'=>[

                ]
            ]);
        }

        public function login(Request $request)
        {
            //VALIDATE PHONE NUMBER

            $info = Account::where('username',$request->username)->first();

            if(!$info){
                return response()->json([
                    'status_code'=>404  ,
                    'message'=>'Teacher does not exist.',
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
            $teacher = Teacher::where('account_id',$info->id)->first();
            if(!$teacher){
                return response()->json([
                    'status_code'=>404  ,
                    'message'=>'Teacher does not exist.',
                    'data'=> [

                    ]
                ]);
            }
            $teacher->OauthAcessToken()->where('name','teacher')->delete();
            $access_token = $teacher->createToken('teacher',['teacher'])->accessToken;
            //LOGIN
            
            //RETURN DATA WITH access_TOKEN
            return response()->json([
                'status_code'=>200 ,
                'message'=>'Teacher has successfully logged in OTP.',
                'data'=>[
                    'teacher'=>new TeacherResource($teacher),
                    'access_token'=>$access_token
                ]
            ]);
        }

        public function logout(Request $request)
        {
            $request->user()->OauthAcessToken()->where('name','teacher')->delete();

            return response()->json([
                'status_code'=>200 ,
                'message'=>'Logout successful.',
                'data'=>[

                ]
            ]);
        }
}