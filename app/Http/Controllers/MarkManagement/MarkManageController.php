<?php

namespace App\Http\Controllers\MarkManagement;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssignCollection;
use App\Http\Resources\TypeCollection;
use App\Http\Resources\DivisionCollection;
use App\Http\Resources\LopCollection;
use App\Http\Resources\ConductCollection;
use App\Http\Resources\ConductdetailCollection;
use App\Http\Resources\ConductResource;
use App\Http\Resources\TypeResource;
use App\Http\Resources\MarkCollection;

use App\Models\Subject;
use App\Models\Fif;
use App\Models\Conduct;
use App\Models\Assign;
use App\Models\Division;
use App\Models\Type;
use App\Models\Lop;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarkManageController extends Controller
{
    public function getSubjectClass($id)
    {
        if (Teacher::where('id', $id)->exists()) 
        {
            $teacher = Teacher::find($id);
            return new AssignCollection(Assign::where('teacher_id', '=', $id)->paginate(15));
        }else {
            return response()->json([
                "message" => "Teacher not found"
            ], 404);
        }
    }
    public function getmarkDetail($id)
    {
        if (Lop::where('id', $id)->exists()) {
            $lop = Lop::find($id);
            return new DivisionCollection(Division::where('lop_id', '=', $id)->paginate(15));
        } else {
            return response()->json([
                "message" => "Division not found"
            ], 404);
        }
    }
    public function Getclass($id)
    {
        if (Teacher::where('id', $id)->exists()) {
            $teacher = Teacher::find($id);
            return new LopCollection(Lop::where('teacher_id', '=', $id)->paginate(15));
        } else {
            return response()->json([
                "message" => "Teacher not found"
            ], 404);
        }
    }
    public function GetConduct($id)
    {
        if (Lop::where('id', $id)->exists()) {
            $lop = Lop::find($id);
            return new ConductCollection(Division::where('lop_id', '=', $id)->paginate(15));
        } else {
            return response()->json([
                "message" => "Division not found"
            ], 404);
        }
    }
    public function getConductDetail($id)
    {
        if (Division::where('id', $id)->exists()) {
            $division = Division::find($id);
            return new ConductdetailCollection(Division::where('student_id', '=', $division->student_id)->paginate(15));
        } else {
            return response()->json([
                "message" => "Division not found"
            ], 404);
        }
    }
    public function GetAlllMark()
    {

        return new MarkCollection(Division::paginate(10));
    }
    public function updateConduct(Request $request, int $id)
    {
        //
        if (Division::where('id', $id)->exists()) {
            $division = Division::find($id);
            $division->student->conduct->mark = is_null($request->mark) ? $division->student->conduct->mark : $request->mark;
            $division->student->conduct->comment = is_null($request->comment) ? $division->student->conduct->comment : $request->comment;
            $division->student->conduct->semester = is_null($request->semester) ? $division->student->conduct->semester : $request->semester;
            $division->student->conduct->schoolYear = is_null($request->schoolYear) ? $division->student->conduct->schoolYear : $request->schoolYear;
            $division->student->conduct->save();
            $division->student->conduct->touch();
            return response()->json([
                "message" => "Conduct updated successfully",
                "request"=> $request
                // "date" => $birthday
            ], 200);
        } else {
            return response()->json([
                "message" => "Conduct not found"
            ], 404);

        }

    }
    public function showConduct($id)
    {
        if (Conduct::where('id', $id)->exists()) {
            $conduct = Conduct::find($id);
            return new ConductResource($conduct);
        } else {
            return response()->json([
                "message" => "Conduct not found"
            ], 404);
        }
    }
    public function updateMark(Request $request, int $id)
    {
        
        if (Division::where('id', $id)->exists()) 
        {
            $division = Division::find($id);

            $obj_fif = $request->fif;
            $obj_fort = $request->fort;
            $obj_nine = $request->nine;

            $fifs = $division->type->fifs;
            $forts = $division->type->forts;
            $nines = $division->type->nines;
            
            foreach( $obj_fif as $key => $value )
            {
                foreach ($fifs as $fif) 
                {
                    if ($key === ($fif->id)){
                        $fif->mark = is_null($value) ? $fif->mark: $value;
                        $fif->save();
                    }
                }

            }
            foreach( $obj_fort as $key => $value )
            {
                foreach ($forts as $fort) 
                {
                    if ($key === ($fort->id)){
                        $fort->mark = is_null($value) ? $fort->mark: $value;
                        $fort->save();
                    }
                }

            }
            foreach( $obj_nine as $key => $value )
            {
                foreach ($nines as $nine) 
                {
                    if ($key === ($nine->id)){
                        $nine->mark = is_null($value) ? $nine->mark: $value;
                        $nine->save();
                    }
                }

            }
            $fifs->save();
            $forts->save();
            $nines->save();
            return response()->json([
                'fif' => $fifs,
                'fif' => $forts,
                'fif' => $nines,
                ], 200);
        } else {
            return response()->json([
                "message" => "Mark not found"
                

            ], 404);

        }

    }
    public function showMark($id)
    {
        if (Conduct::where('id', $id)->exists()) {
            $conduct = Conduct::find($id);
            return new ConductResource($conduct);
        } else {
            return response()->json([
                "message" => "Conduct not found"
            ], 404);
        }
    }
    public function GetMark($id)
    {
        if (Type::where('id', $id)->exists()) {
            $type = Type::find($id);
            return new MarkCollection(Type::where('id',$id)->paginate(15));
        } else {
            return response()->json([
                "message" => "Division not found"
            ], 404);
        }
    }
}