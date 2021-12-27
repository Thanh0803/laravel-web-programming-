<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\Account;


class StudentController extends Controller
{
    public function register(Request $request)
        {
            //VALIDATION HERE

            $info = Account::create([
                'username'=>$request->username,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'role' => 2
            ]);
            if($info->id){
                $student = Student::create([
                    'account_id' => $info->id,
                ]);
            }
            
            //REGISTER NEW USER BY RECORDING NAME, PHONE
            return response()->json([
                'status_code'=>200,
                'message'=>'Student registered successfully.',
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
                    'message'=>'Student does not exist.',
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
            $student = Student::where('account_id',$info->id)->first();
            if(!$student){
                return response()->json([
                    'status_code'=>404  ,
                    'message'=>'Student does not exist.',
                    'data'=> [

                    ]
                ]);
            }
            $student->OauthAcessToken()->where('name','student')->delete();
            $access_token = $student->createToken('student',['student'])->accessToken;
            //LOGIN
            
            //RETURN DATA WITH access_TOKEN
            return response()->json([
                'status_code'=>200 ,
                'message'=>'Student has successfully logged in OTP.',
                'data'=>[
                    'user'=>$student,
                    'access_token'=>$access_token
                ]
            ]);
        }

        public function logout(Request $request)
        {
            $request->user()->OauthAcessToken()->where('name','student')->delete();

            return response()->json([
                'status_code'=>200 ,
                'message'=>'Logout successful.',
                'data'=>[

                ]
            ]);
        }
}
