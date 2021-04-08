<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\App\Catalogue;
use App\Models\App\Institution;
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Course;

class CourseController extends Controller
{
    // Muestra lista de cursos existentes aqui//
    function index(Request $request)
    {

        $couses = $request->json()->all();

        return response()->json([
            'data' => $couses,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
            ]
        ], 200);
    }

    // Muestra el dato especifico del Curso//
    function show($id)

    {
        $course = Course::findOrFail($id);
        return response()->json([
            'data' => $course,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
            ]
        ], 200);
    }


    //Almacena los  Datos creado del curso envia//

    function store(Request $request)
    {

        $data = $request->json()->all();
        $dataCourse = $data['course'];

        $course = new Course();
        $course->name = $dataCourse['name'];
        $course->description = $dataCourse['description'];
        $course->start_date = $dataCourse['start_date'];
        $course->end_date = $dataCourse['end_date'];
        $course->hours = $dataCourse['hours'];

        $course->professional()->associate(Professional::findOrFail($request->Profesional_id));
        $course->institution()->associate(Institution::findOrFail($request->Institution_id));
        $course->type()->associate(Catalogue::findOrFail($request->Type_id));
        $course->certificationType()->associate(Catalogue::findOrFail($request->CertificationType_id));
        $course->save();
    }



    //Actualiza los datos del curso creado//
    function update(Request $request, $id)
    {
        $data = $request->json()->all();
        $dataCourse = $data['course'];

        $course = Course::findOrFail($id);
        $course->name = $dataCourse['name'];
        $course->description = $dataCourse['description'];
        $course->start_date = $dataCourse['start_date'];
        $course->end_date = $dataCourse['end_date'];
        $course->hours = $dataCourse['hours'];

        $course->professional()->associate(Professional::findOrFail($request->Profesional_id));
        $course->institution()->associate(Institution::findOrFail($request->Institution_id));
        $course->type()->associate(Catalogue::findOrFail($request->Type_id));
        $course->certificationType()->associate(Catalogue::findOrFail($request->CertificationType_id));
        $course->save();
    }

    //Elimina los datos del curso//
    function destroy($id)
    {


        $course = Course::findOrFail($id);
        $course->state = false;;

        $course->save();
    }
}