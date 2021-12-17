<?php

namespace App\Http\Controllers\AccountManage;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Http\Resources\GradeCollection;
use App\Http\Resources\GradeResource;
use App\Http\Resources\LopCollection;
use App\Http\Resources\StudentListCollection;
use App\Http\Resources\DivisionCollection;
use App\Http\Resources\SubjectCollection;
use App\Http\Resources\AssignCollection;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Assign;
use App\Models\Lop;
use App\Models\Teacher;
use App\Models\Grade;
use App\Models\Division;
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
            return new GradeCollection(Grade::where('id',$id)->paginate(10));
        } else {
            return response()->json([
                "message" => "Grade not found"
            ], 404);
        }
    }
    public function getClass($id)
    {
        if (Grade::where('id', $id)->exists()) {
            $lops = Lop::where('grade_id', '=', $id)->paginate(15);
            return new LopCollection($lops);
        } else {
            return response()->json([
                "message" => "Grade not found"
            ], 404);
        }
    }
    public function getAllStudent($id)
    {
        if (Lop::where('id', $id)->exists()) {
            $lop = Lop::find($id);
            return new DivisionCollection(Division::where('lop_id', '=', $id)->paginate(15));
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);
        }
    }
    public function getAllTeacher($id)
    {
        if (Subject::where('id', $id)->exists()) {
            $subject = Subject::find($id);
            return new AssignCollection(Assign::where('subject_id', '=', $id)->paginate(15));
        } else {
            return response()->json([
                "message" => "Subject not found"
            ], 404);
        }
    }
    public function getAllSubject()
    {
        return new SubjectCollection(Subject::all());
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
