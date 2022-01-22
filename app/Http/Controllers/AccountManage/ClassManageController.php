<?php

namespace App\Http\Controllers\AccountManage;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\GradeCollection;
use App\Http\Resources\GradeResource;
use App\Http\Resources\LopCollection;
use App\Http\Resources\StudentListCollection;
use App\Http\Resources\DivisionnotypeCollection;
use App\Http\Resources\SubjectCollection;
use App\Http\Resources\AssignCollection;
use App\Http\Resources\LevelCollection;
use App\Http\Resources\LopResource;
use App\Http\Resources\DivisionStudentCollection;
use App\Http\Resources\TypeCollection;
use App\Http\Resources\ConductStudentCollection;

use App\Models\Student;
use App\Models\Admin;
use App\Models\Type;
use App\Models\Conduct;
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
    public function getTotalClass(){
        return Lop::count();
    }
    public function getTotalAdmin(){
        return Admin::count();
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
    public function getClassSchoolYear($schoolyear, $id)
    {
        if (Grade::where('id', $id)->exists()) {
            $lops = Lop::where('grade_id', '=', $id)->where('schoolYear','=',$schoolyear)->paginate(15);
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
            return new DivisionnotypeCollection(Division::where('lop_id', '=', $id)->paginate(15));
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
            return new AssignCollection(Assign::where('subject_id', '=', $subject->id)->paginate(15));

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
    public function updateAssign(Request $request, int $id)
    {
        //
        if (Assign::where('id', $id)->exists()) {
            $assign = Assign::find($id);
            $assign->teacher->fullname = is_null($request->fullname) ? $assign->teacher->fullname : $request->fullname;
            $assign->lop->className = is_null($request->className) ? $assign->lop->className : $request->className;
            $assign->semester = is_null($request->semester) ? $assign->semester : $request->semester;
            $assign->lop->schoolYear = is_null($request->schoolYear) ? $assign->lop->schoolYear : $request->schoolYear;
            $assign->save();
            $assign->teacher->save();
            $assign->lop->save();
            $assign->touch();
            $assign->teacher->touch();
            $assign->lop->touch();
            return response()->json([
                "message" => "Student updated successfully",
                "assign"=> $request,
                // "date" => $birthday
            ], 200);
        } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);

        }

    }
    public function getAssignDetail($id)
    {
        if (Assign::where('id', $id)->exists()) {
            $assign = Assign::find($id);
            return new AssignCollection(Assign::where('id', $id)->paginate(15));
        } else {
            return response()->json([
                "message" => "Assign not found"
            ], 404);
        }
    }
    public function getClassStudent($id)
    {
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            return new DivisionStudentCollection(Division::where('student_id','=', $id)->paginate(15));
        } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }
    public function getMarkStudent1($id, $id_semester)
    {
        if (Division::where('id', $id)->exists()) {
            $division = Division::find($id);
            return new TypeCollection(Type::where('division_id','=', $id)->where('semester', '=', $id_semester)->paginate(15));
        } else {
            return response()->json([
                "message" => "Division not found"
            ], 404);
        }
    }
    public function getMarkStudent2($id, $id_semester)
    {
        if (Division::where('id', $id)->exists()) {
            $division = Division::find($id);
            return new TypeCollection(Type::where('division_id','=', $id)->where('semester', '=', $id_semester)->paginate(15));
        } else {
            return response()->json([
                "message" => "Division not found"
            ], 404);
        }
    }
    public function getConductStudent($id)
    {
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            return new ConductStudentCollection(Conduct::where('student_id','=', $id)->paginate(15));
        } else {
            return response()->json([
                "message" => "Division not found"
            ], 404);
        }
    }
    public function classReport($id)
    {   
        $mark = 0;
        $count =0;
        $arrs=[];
        $verygood=0;
        $good=0;
        $average=0;
        $lower_avg=0;
        if (Lop::where('id', $id)->exists())
        {
            $lop = Lop::find($id);
            $divisions = $lop->divisions;
            foreach($divisions as $division){
                $types = $division->types;
                $lenght = sizeof($types);
                foreach($types as $type)
                {
                    $fifs = $type->fifs;
                    foreach($fifs as $fif)
                    {
                        $count += 1;
                        $mark = $mark + $fif->mark;
                    }
                    $forts = $type->forts;
                    foreach($forts as $fort)
                    {
                        $count += 2;
                        $mark = $mark + 2*$fort->mark;
                    }
                    $nines = $type->nines;
                    foreach($nines as $nine)
                    {
                        $count += 3;
                        $mark = $mark + 3*$nine->mark;
                    }
                    
                }
                $avg = $mark/$count;
                $arrs[] = $avg;
                $mark = 0;
                $count =0;
            }
            foreach($arrs as $arr)
            {
                if ($arr >= 8)
                {
                    $verygood+=1;
                }elseif(6.5 <= $arr && $arr< 8)
                {
                    $good+=1;
                }elseif(5.0 <= $arr && $arr<6.5){
                    $average+=1;
                }else{
                    $lower_avg+=1;
                }
            }    
            return response()->json([
                "very_good" => $verygood,
                "good"=>$good,
                "average"=>$average,
                "lower_average"=>$lower_avg,
                "total"=>sizeof($divisions)
            ]);
        } else {
            return response()->json([
                "message" => "Lop not found"
            ], 404);
        }
    }
    public function gradeReport($schoolyear, $id)
    {   

        $mark = 0;
        $count =0;
        $arrs=[];
        $verygood=0;
        $good=0;
        $average=0;
        $lower_avg=0;
        $total =0;
        if (Grade::where('id', $id)->exists())
        {
            $grade= Grade::find($id);
            // $lops = $grade->lops;
            $lops = Lop::where('grade_id','=',$grade->id)->where('schoolYear','=',$schoolyear)->get();
            foreach($lops as $lop)
            {
                $divisions = $lop->divisions;
                $total = $total+sizeof($divisions);
                foreach($divisions as $division){
                    $types = $division->types;
                    $lenght = sizeof($types);
                    foreach($types as $type)
                    {
                        $fifs = $type->fifs;
                        foreach($fifs as $fif)
                        {
                            $count += 1;
                            $mark = $mark + $fif->mark;
                        }
                        $forts = $type->forts;
                        foreach($forts as $fort)
                        {
                            $count += 2;
                            $mark = $mark + 2*$fort->mark;
                        }
                        $nines = $type->nines;
                        foreach($nines as $nine)
                        {
                            $count += 3;
                            $mark = $mark + 3*$nine->mark;
                        }
                        
                    }
                    $avg = $mark/$count;
                    $arrs[] = $avg;
                    $mark = 0;
                    $count =0;
                }
            }
            foreach($arrs as $arr)
                {
                    if ($arr >= 8)
                    {
                        $verygood+=1;
                    }elseif(6.5 <= $arr && $arr< 8)
                    {
                        $good+=1;
                    }elseif(5.0 <= $arr && $arr<6.5){
                        $average+=1;
                    }else{
                        $lower_avg+=1;
                    }
                }  
              
            return response()->json([
                // "lop" =>$lops,
                "very_good" => $verygood,
                "good"=>$good,
                "average"=>$average,
                "lower_average"=>$lower_avg,
                "total"=>$total
            ]);
        } else {
            return response()->json([
                "message" => "Grade not found"
            ]);
        }
    }
    public function subjectReport($string, $id)
    {
        $count =0;
        $division_ids = [];
        $mark = 0;
        $arrs=[];
        $verygood=0;
        $good=0;
        $average=0;
        $lower_avg=0;
        $total =0;
        if (Subject::where('grade', $id)->exists()) {
            // $subs = new SubjectCollection(Subject::where('grade',$id)->paginate(15));
            $subs = Subject::where('grade', $id)->get();
            foreach($subs as $sub)
            {
                if ($sub->subjectName == $string)
                {
                    $types_1=$sub->types;
                    foreach($types_1 as $types_1)
                    {
                        if(in_array($types_1->division_id, $division_ids) == FALSE)
                        {
                            $division_ids[] = $types_1->division_id;
                        }
                        
                    }
                }
            }
            
            foreach($division_ids as $division_id)
            {
                $types = Type::where('division_id', '=', $division_id)->get();
                foreach($types as $type)
                {
                    $fifs = $type->fifs;
                    foreach($fifs as $fif)
                    {
                        $count += 1;
                        $mark = $mark + $fif->mark;
                    }
                    $forts = $type->forts;
                    foreach($forts as $fort)
                    {
                        $count += 2;
                        $mark = $mark + 2*$fort->mark;
                    }
                    $nines = $type->nines;
                    foreach($nines as $nine)
                    {
                        $count += 3;
                        $mark = $mark + 3*$nine->mark;
                    }
                }
                $avg = $mark/$count;
                $arrs[] = $avg;
                $mark = 0;
                $count =0;
            }
            foreach($arrs as $arr)
                {
                    if ($arr >= 8)
                    {
                        $verygood+=1;
                    }elseif(6.5 <= $arr && $arr< 8)
                    {
                        $good+=1;
                    }elseif(5.0 <= $arr && $arr<6.5){
                        $average+=1;
                    }else{
                        $lower_avg+=1;
                    }
                }  
            
            return response()->json([
                "very_good" => $verygood,
                "good"=>$good,
                "average"=>$average,
                "lower_average"=>$lower_avg,
                "total"=>sizeof($division_ids)
            ]);
        } else {
            return response()->json([
                "message" => "Subject not found"
            ]);

        }
    }
    public function gradeConductReport($schoolyear, $id)
    {
        $very_good =0;
        $good=0;
        $average=0;
        $lower_avg=0;
        $fail=0;
        $arrs=[];
        if (Grade::where('id', $id)->exists())
        {
            $grade = Grade::find($id);
            // $lops =$grade->lops;
            $lops = Lop::where('grade_id','=',$grade->id)->where('schoolYear','=',$schoolyear)->get();
            foreach($lops as $lop)
            {
                $divisions = $lop->divisions;
                foreach($divisions as $division)
                {
                    $conducts = $division->student->conducts;
                    foreach($conducts as $conduct)
                    {
                        if($conduct->semester ==2)
                        {
                            $arrs[]=$conduct->mark;
                        }
                    }
                }

            }
            foreach($arrs as $arr)
            {
                if ($arr == 'Very Good'){
                    $very_good+=1;
                }else if ($arr == 'Good'){
                    $good+=1;
                }else if ($arr == 'Average'){
                    $average+=1;
                }else{
                    $lower_avg+=1;
                }
            }
            return response()->json([
                "very_good" => $very_good,
                "good" => $good,
                "average" => $average,
                "lower_average" => $lower_avg,
                "total" => sizeof($arrs),
            ]);
        }else {
            return response()->json([
                "message" => "Conduct not found"
            ]);
        }
    }
    public function classConductReport($id)
    {
        $very_good =0;
        $good=0;
        $average=0;
        $lower_avg=0;
        $fail=0;
        $arrs=[];
        if(Lop::where('id', $id)->exists())
        {
            $lop = Lop::find($id);
            $divisions = $lop->divisions;
            foreach($divisions as $division)
            {
                $conducts = $division->student->conducts;
                foreach($conducts as $conduct)
                {
                    if($conduct->semester ==2)
                        {
                            $arrs[]=$conduct->mark;
                        }
                }
            }
            foreach($arrs as $arr)
            {
                if ($arr == 'Very Good'){
                    $very_good+=1;
                }else if ($arr == 'Good'){
                    $good+=1;
                }else if ($arr == 'Average'){
                    $average+=1;
                }else{
                    $lower_avg+=1;
                }
            }
            return response()->json([
                "very_good" => $very_good,
                "good" => $good,
                "average" => $average,
                "lower_average" => $lower_avg,
                "total" => sizeof($arrs),
            ]);
        }else {
            return response()->json([
                "message" => "Lop not found"
            ]);
        }
    }
    public function getClassDetail($id)
    {
        if (Lop::where('id', $id)->exists()) {
            $lop = Lop::find($id);
            return new LopResource($lop);
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);
        }
    }
    public function editClass(Request $request, int $id)
    {
        //
        if (Lop::where('id', $id)->exists()) {
            $lop = Lop::find($id);
            $lop->teacher->fullname = is_null($request->fullname) ? $lop->teacher->fullname : $request->fullname;
            $lop->teacher->account->username = is_null($request->username) ? $lop->teacher->account->username : $request->username;
            $lop->teacher->account->email = is_null($request->email) ? $lop->teacher->account->email : $request->email;
            $lop->className = is_null($request->className) ? $lop->className : $request->className;
            $lop->grade_id = is_null($request->grade_id) ? $lop->grade_id : $request->grade_id;
            $lop->academicYear = is_null($request->academicYear) ? $lop->academicYear : $request->academicYear;
            $lop->schoolYear = is_null($request->schoolYear) ? $lop->schoolYear : $request->schoolYear;
            $lop->save();
            $lop->teacher->account->save();
            $lop->touch();
            return response()->json([
                "message" => "Class updated successfully",
                "lop"=> $request,
            ], 200);
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);

        }

    }
}
