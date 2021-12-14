<?php

namespace App\Http\Controllers\AccountManage;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Http\Resources\GradeCollection;
use App\Http\Resources\GradeResource;
use App\Http\Resources\LopCollection;

use App\Models\Student;
use App\Models\Lop;
use App\Models\Teacher;
use App\Models\Grade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassManageController extends Controller
{
    public function getAllGrade()
    {
        return new GradeCollection(Grade::all());
    }
    public function getAllClassinGrade($id)
    {
        if (Grade::where('id', $id)->exists()) {
            // $achievement = Achievement::where('classSubject_id',$classSubject_id)->where('student_id',$student)->get()[0];
            return new GradeCollection(Grade::where('id',$id)->paginate(10));
        } else {
            return response()->json([
                "message" => "Grade not found"
            ], 404);
        }
        // return new GradeCollection(Grade::all());
    }
    public function getClass($id, $lop_id)
    {
        if (Grade::where('id', $id)->exists()) {
            $lops = Lop::where('grade_id', '=', $id)->paginate(15);
            foreach ($lops as $lop){
                $lop -> gradeObj = $lop_id;
            }
            return new LopCollection($lops);
        } else {
            return response()->json([
                "message" => "Grade not found"
            ], 404);
        }
    }
    public function upload(Request $request){
        //
                $lops = $request->data;
                $count = 0;
                DB::beginTransaction();
                try {
                    foreach ($lops as $lop) {
                            $input = Lop::create(
                                [
                                    'className' => $lop['className'],
                                    'grade_id' => $lop['grade_id'],
                                    'teacher_id' => $lop['teacher_id'],
                                ]
                            );
                            $input->academicYear =$lop['academicYear'];
                            $input->schoolYear =$lop['schoolYear'];
                            $input->save();
                            $input->touch();
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
    public function delete($id)
    {
        //
        if(Lop::where('id', $id)->exists()) {
            $lop = Lop::find($id);
            $lop->delete();

            return response()->json([
                "message" => "Class deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);
        }
    }
}
