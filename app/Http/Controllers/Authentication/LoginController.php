<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Account;
use App\Models\Admin;

use App\Http\Resources\AccountResource;
use App\Http\Resources\AdminResource;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\StudentResource;

class LoginController extends Controller
{
    //
    public function login(Request $request)
        {
            //VALIDATE PHONE NUMBER

            $info = Account::where('username',$request->username)->first();

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
            $admin = Admin::where('account_id',$info->id)->first();
            $teacher = Teacher::where('account_id',$info->id)->first();
            $student = Student::where('account_id',$info->id)->first();
            if($admin){
                $admin->OauthAcessToken()->where('name','admin')->delete();
                $access_token = $admin->createToken('admin',['admin'])->accessToken;
                return response()->json([
                    'status_code'=>200 ,
                    'message'=>'Admin has successfully logged in OTP.',
                    'data'=>[
                        'user'=>new AdminResource($admin),
                        'role'=>0,
                        'access_token'=>$access_token
                    ]
                ]);
            }elseif($teacher){
                $teacher->OauthAcessToken()->where('name','teacher')->delete();
                $access_token = $teacher->createToken('teacher',['teacher'])->accessToken;
                return response()->json([
                    'status_code'=>200 ,
                    'message'=>'Teacher has successfully logged in OTP.',
                    'data'=>[
                        'user'=>new TeacherResource($teacher),
                        'role'=>1,
                        'access_token'=>$access_token
                    ]
                ]);
            } elseif($student){
                $student->OauthAcessToken()->where('name','student')->delete();
                $access_token = $student->createToken('student',['student'])->accessToken;
                return response()->json([
                    'status_code'=>200 ,
                    'message'=>'Student has successfully logged in OTP.',
                    'data'=>[
                        'user'=>new StudentResource($student),
                        'role'=>2,
                        'access_token'=>$access_token
 
                    ]
                ]);
            }else{
                return response()->json([
                    'status_code'=>404  ,
                    'message'=>'User does not exist.',
                    'data'=>[

                    ]
                ]);
            }
            
        }
}
