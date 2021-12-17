<?php

namespace App\Http\Controllers\AccountManage;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Http\Resources\GradeCollection;
use App\Http\Resources\GradeResource;

use App\Models\Student;
use App\Models\Account;
use App\Models\Teacher;
use App\Models\Grade;
use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentManageController extends Controller
{
    public function getAllStudent()
    {
        //
//        return StudentResource::collection(Student::all());
        return new StudentCollection(Student::paginate(10));
//        return User::all();
    }
    // public function getTotalStudent(){
    //     return Student::count();
    // }
   
//     public function store(Request $request)
//     {
//         $student = Student::create([
//             'email' => $request->email,
//             'name' => $request->name,
//             'password' => bcrypt($request->password),

//         ]);
//         return new StudentResource($student);
//     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            return new StudentResource($student);
        } else {
            return response()->json([
                "message" => "Student not found"
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
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->account->username = is_null($request->username) ? $student->account->username : $request->username;
            $student->account->email = is_null($request->email) ? $student->account->email : $request->email;
            $student->fullname = is_null($request->fullname) ? $student->fullname : $request->fullname;
            $student->phone = is_null($request->phone) ? $student->phone : $request->phone;
            $student->gender = is_null($request->gender) ? $student->gender : $request->gender;
            $birthday = is_null($request->birthdayYear) ? $student->birthday : Carbon::createFromDate($request->birthdayYear, $request->birthdayMonth, $request->birthdayDate, 'Asia/Ho_Chi_Minh') ;
            $student->birthday = $birthday;            
            $student->account->password = is_null($request->password) ? $student->account->password : bcrypt($request->password);
            $student->fatherName = is_null($request->fatherName) ? $student->fatherName : $request->fatherName;
            $student->fatherPhone = is_null($request->fatherPhone) ? $student->fatherPhone : $request->fatherPhone;
            $student->fatherCareer = is_null($request->fatherCareer) ? $student->fatherCareer : $request->fatherCareer;
            $student->motherName = is_null($request->motherName) ? $student->motherName : $request->motherName;
            $student->motherPhone = is_null($request->motherPhone) ? $student->motherPhone : $request->motherPhone;
            $student->motherCareer = is_null($request->motherCareer) ? $student->motherCareer : $request->motherCareer;
            $student->save();
            $student->account->save();
            $student->touch();
            return response()->json([
                "message" => "Student updated successfully",
                // "student"=> new StudentResource($student),
                // "date" => $birthday
            ], 200);
        } else {
            return response()->json([
                "message" => "Student not found"
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
        if(Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->delete();

            return response()->json([
                "message" => "Student deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }
    public function upload(Request $request, int $id){
//
        $students = $request->data;
        $count = 0;
//        foreach ($students as $student) {
//            $class = Lophoc::where("classname",$student['classname'])->where("school",$student['school'])->get();
//        }

        DB::beginTransaction();
        try {
            foreach ($students as $student) {
                    $account = Account::create(
                        [
                            'email' => $student['email'],
                            'username' => $student['username'],
                            'password' => bcrypt($student['password'])
//
                        ]
                    );
                    $input = Student::create(
                        [
                            'account_id' => $account->id
                        ]
                    );
                    $birthday = Carbon::createFromDate($student['birthdayYear'], $student['birthdayMonth'], $student['birthdayDate'], 'Asia/Ho_Chi_Minh');
                    $input->birthday = $birthday;
                    $input->fullname = $student['fullname'];
                    $input->gender =$student['gender'];
                    $input->phone =$student['phone'];
                    $input->fatherName = $student['fatherName'];
                    $input->fatherCareer = $student['fatherCareer'];
                    $input->fatherPhone = $student['fatherPhone'];
                    $input->motherName = $student['motherName'];
                    $input->motherCareer = $student['motherCareer'];
                    $input->motherPhone = $student['motherPhone'];
                    $input->save();
                    $input->touch();

                    $division= Division::create(
                        [
                            'student_id' => $input->id,
                            'lop_id' => $id,
                        ]
                    );
                }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());

        }
        return response()->json([
            "message" => "Created success",
            "count" => $count,
//            "class" => count($class)
        ]);


    }
    public function multiDelete(Request $request){
        $ids = $request->ids;
        DB::table("students")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(["message" => "Student deleted"]);
    }

    public function search(Request $request)
    {
//        $student = Student::query()
//            ->fullname($request->keyword)
//            ->name($request->keyword);

        $student = Student::where('fullname', 'LIKE','%'.$request->keyword.'%')
            ->where('lophoc_id', '=',null)
            ->get();
        return response()->json([
//            "message" => "Class updated successfully",
            "student"=> $student,
            "count" => $student->count()
        ], 200);
    }
    public function studentWithSubjectScore(){

    }
    public function countByMonth()
    {
        $users = Student::select('id', 'created_at')
            ->get()
            ->groupBy(function($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

        $usermcount = [];
        $userArr = [];
        $month = [
            'No','Jan','Feb','Mar','Apr','May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
        foreach ($users as $key => $value) {
            $usermcount[(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++){
            if(!empty($usermcount[$i])){

                $userArr[$i] = $usermcount[$i];
            }else{
                $userArr[$i] = 0;
            }
        }
        return response()->json([
//            "data" => $usermcount,
            "data_hi" => $userArr
        ], 200);

    }

}
