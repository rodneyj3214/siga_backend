<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JobBoard\AcademicFormation;
use App\Models\JobBoard\Category;
use App\Models\JobBoard\Professional;

class AcademicFormationController extends Controller
{
    function index()
    {
        $academicFormations = AcademicFormation::all();

        return response()->json([
            'data' => $academicFormations,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function show($id)
    {
        $academicFormation = AcademicFormation::findOrFail($id);

        return response()->json([
            'data' => $academicFormation,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function store(Request $request)
    {
        $data = $request->json()->all();
        $dataAcademicFormation = $data['academic_formation'];
        $dataCategory = $data['category'];

        $academicFormation = new AcademicFormation();
        $academicFormation->professional_degree_id = $dataAcademicFormation['professional_degree_id'];
        $academicFormation->registration_date = $dataAcademicFormation['registration_date'];
        $academicFormation->senescyt_code = $dataAcademicFormation['senescyt_code'];
        $academicFormation->has_titling = $dataAcademicFormation['has_titling'];
        
        $academicFormation->professional()->associate(Professional::firstWhere('user_id', $request->user()->id));
        $academicFormation->category()->associate(Category::findOrFail($dataCategory['id']));

        $academicFormation->save();
    }

    function update(Request $request, $id)
    {
        $data = $request->json()->all();
        $dataAcademicFormation= $data['academic_formation'];
        $dataCategory = $data['category'];

        $academicFormation = AcademicFormation::findOrFail($id);
        $academicFormation->registration_date = $dataAcademicFormation['registration_date'];
        $academicFormation->senescyt_code = $dataAcademicFormation['senescyt_code'];
        $academicFormation->has_titling = $dataAcademicFormation['has_titling'];

        $academicFormation->professional()->associate(Professional::firstWhere('user_id',$request->user()->id));
        $academicFormation->category()->associate(Category::findOrFail($dataCategory['id']));

        $academicFormation->save();
    }

    function destroy($id)
    {
        $academicFormation = AcademicFormation::findOrFail($id);
        $academicFormation->state = false;

        $academicFormation->save();
    }
}
