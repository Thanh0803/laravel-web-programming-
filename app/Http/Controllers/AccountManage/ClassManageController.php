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
use App\Http\Resources\LevelCollection;
use App\Http\Resources\LopResource;

use App\Models\Student;
use App\Models\Level;
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
            return new GradeCollection(Grade::where('id',$id)->all());
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
            return new LevelCollection(Level::where('subject_id', '=', $id)->paginate(15));
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
    public function store(Request $request, int $id)
    {
        $lop = Lop::create([
            'teacher_id'=>$request->teacher_id,
            'className'=>$request->className,
            'grade_id'=>$id,

        ]);
        $lop->academicYear =$request->academicYear;
        $lop->schoolYear =$request->schoolYear;
        $lop->save();
        return response()->json([
            'status_code' => 200,
            'message' => "Class created successfully.",
            'data' => [
//                "class"=>$request->teacher_id,
                "class"=> new LopResource($lop),

            ],
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
    public function getAllAssign()
    {
        return new AssignCollection(Assign::paginate(15));
    }
}
