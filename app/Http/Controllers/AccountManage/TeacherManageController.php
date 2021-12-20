<?php

namespace App\Http\Controllers\AccountManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\TeacherResource;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Account;
use App\Models\Level;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class TeacherManageController extends Controller
{
    //
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUser()
    {

        return new TeacherCollection(Teacher::paginate(10));
    }
    public function getTotalTeacher(){
        return Teacher::count();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $teacher = Teacher::create([
    //         'email' => $request->email,
    //         'name' => $request->name,
    //         'password' => bcrypt($request->password),

    //     ]);
    //     return new TeacherResource($teacher);
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Teacher::where('id', $id)->exists()) {
            $teacher = Teacher::find($id);
            return new TeacherResource($teacher);
        } else {
            return response()->json([
                "message" => "Teacher not found"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
        if (Teacher::where('id', $id)->exists()) {
            $teacher = Teacher::find($id);
            $teacher->account->username = is_null($request->username) ? $teacher->account->username : $request->username;
            $teacher->account->email = is_null($request->email) ? $teacher->account->email : $request->email;
            $teacher->fullname = is_null($request->fullname) ? $teacher->fullname : $request->fullname;
            $teacher->level = is_null($request->level) ? $teacher->level : $request->level;
            $teacher->phone = is_null($request->phone) ? $teacher->phone : $request->phone;
            $teacher->gender = is_null($request->gender) ? $teacher->gender : $request->gender;
            $teacher->account->password = is_null($request->password) ? $teacher->account->password : bcrypt($request->password);
            $teacher->headTeacher = is_null($request->headTeacher) ? $teacher->headTeacher : $request->headTeacher;
            $birthday = is_null($request->birthdayYear) ? $teacher->birthday : Carbon::createFromDate($request->birthdayYear, $request->birthdayMonth, $request->birthdayDate, 'Asia/Ho_Chi_Minh') ;
            $teacher->birthday = $birthday;   

            $teacher->save();
            $teacher->account->save();
            return response()->json([
                "message" => "records updated successfully",
                // 'email'=>$teacher->account->email,
                // 'username'=>$teacher->account->username

                // "teacher"=> $teacher
            ], 200);
        } else {
            return response()->json([
                "message" => "Teacher not found"
            ], 404);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        if(Teacher::where('id', $id)->exists()) {
            $teacher = Teacher::find($id);
            $teacher->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Teacher not found"
            ], 404);
        }
    }
    public function upload(Request $request, int $id){
        $teachers = $request->data;
       
        $count = 0;
        $date  = Carbon::now();
        DB::beginTransaction();
        try {
            foreach ($teachers as $teacher) {

            $account = Account::create(
                [
                    'email' => $teacher['email'],
                    'username' => $teacher['username'], 
                    'password' => bcrypt($teacher['password']) 
                ]
            );
            $input = Teacher::create(
                [
                    'account_id' => $account->id
                ]
            );
            $birthday = Carbon::createFromDate($teacher['birthdayYear'], $teacher['birthdayMonth'], $teacher['birthdayDate'], 'Asia/Ho_Chi_Minh');
            $input->birthday = $birthday;
            $input->fullname = $teacher['fullname'];
            $input->gender =$teacher['gender'];
            $input->phone =$teacher['phone'];
            $input->save();
            $input->touch();
            $level = Level::create(
                [
                    'teacher_id' => $input->id,
                    'subject_id' => $id,
                ]
            );
            $count++;
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
//
        }
        return response()->json([
            "message" => "Created success",
            "Total created" => $count,
            "Date" => $teacher
            ]);

    }
    public function multiDelete(Request $request){
        $ids = $request->ids;
        DB::table("teachers")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(["message" => "Teacher deleted"]);
    }
    public function teacherStatus($id){
        if (Teacher::where('id', $id)->exists()) {
            $user = User::find($id);
            $classes = Lophoc::where('teacher_id',$id)->get();
//            $class = Lophoc::find()
            $assign = ClassSubject::where('teacher_id',$id)->where('isActive',1)->get();
            return response()->json([
                "classByKeyTeacher" => $classes,
                "classTeach" => new AssignCollection($assign),
            ],200);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }
}
