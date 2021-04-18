<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use App\Models\JobBoard\Reference;
use App\Models\JobBoard\Professional;

use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    function index(Request $request)
    {
        $professional = Professional::getInstance($request->input('professional_id'));

        if ($request->has('search')) {
            $reference = $professional->professionalReferences()
                ->institution($request->input('search'))
                ->position($request->input('search'))
                ->contacName($request->input('search'))
                ->contacPhone($request->input('search'))
                ->contacEmail($request->input('search'))
                ->get();
        } else {
            $reference = $professional->professionalReferences()->paginate($request->input('per_page'));
        }

        if (sizeof($reference) === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Referencias',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        return response()->json($reference, 200);

//        $professional = Professional::where('id', $request->user_id)->first();
//        if (is_null($professional)){
//            return response()->json([
//                'response' => null,
//                'message' => 'No existe ese dato.'
//            ], 200);
//        }
//
//        if ($professional) {
//            $professionalReferences = Reference::where('professional_id', $professional->id)
//                ->where('state', 'ACTIVE')
//                ->orderby($request->field, $request->order)
//                ->paginate($request->limit);
//            return response()->json([
//                'pagination' => [
//                    'total' => $professionalReferences->total(),
//                    'current_page' => $professionalReferences->currentPage(),
//                    'last_page' => $professionalReferences->lastPage(),
//                    'from' => $professionalReferences->firstItem(),
//                    'to' => $professionalReferences->lastItem()
//                ], 'professionalReferences' => $professionalReferences], 200);
//        } else {
//            return response()->json([
//                'pagination' => [
//                    'total' => 0,
//                    'current_page' => 1,
//                    'last_page' => 1,
//                    'from' => null,
//                    'to' => null
//                ], 'professionalReference' => null], 404);
//        }
    }

    function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }

        $professionalReference = Reference::find($id)->first();

        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$professionalReference) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Profesional no encontrado',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        return response()->json([
            'data' => $professionalReference,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);

    }

    function store(Request $request)
    {
        $professional = Professional::getInstance($request->input('professional.id'));

        $references = new Reference();
        $references->professional()->associate($professional);
        $references->institution = $request->input('references.institution');
        $references->position = $request->input('references.position');
        $references->contact_name = $request->input('references.contact_name');
        $references->contact_phone = $request->input('references.contact_phone');
        $references->contact_email = $request->input('references.contact_email');

        $references->save();

        return response()->json([
            'data' => $references,
            'msg' => [
                'summary' => 'Referencia creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);

//        $data = $request->json()->all();
//        $dataUser = $data['user'];
//        $dataProfessionalReference = $data['professionalReference'];
//        $professional = Professional::where('user_id', $dataUser['id'])->first();
//
//        if ($professional) {
//            $response = $professional->professionalReferences()->create([
//                'institution' => strtoupper($dataProfessionalReference ['institution']),
//                'position' => strtoupper($dataProfessionalReference ['position']),
//                'contact_name' => strtoupper($dataProfessionalReference ['contact_name']),
//                'contact_phone' => $dataProfessionalReference ['contact_phone'],
//                'contact_email' => $dataProfessionalReference ['contact_email'],
//            ]);0
//            return response()->json([
//                'response' => $response,
//                'message' => 'successful'
//            ], 200);
//        } else {
//            return response()->json([
//                'response' => null,
//                'message' => 'successful'
//            ], 404);
//        }

    }

    function update(Request $request, $id)
    {
        $references = Reference::find($id)->first();

        if (!$references) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Referencia no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        $references->institution = $request->input('references.institution');
        $references->position = $request->input('references.position');
        $references->contact_name = $request->input('references.contact_name');
        $references->contact_phone = $request->input('references.contact_phone');
        $references->contact_email = $request->input('references.contact_email');

        $references->update();

        return response()->json([
            'data' => $references,
            'msg' => [
                'summary' => 'Referencia actualizada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
//
//        $data = $request->json()->all();
//
//        $dataProfessionalReference = $data['professionalReference'];
//
//        $professionalReference = Reference::findOrFail($dataProfessionalReference['id'])->update([
//            'institution' => strtoupper($dataProfessionalReference ['institution']),
//            'position' => strtoupper($dataProfessionalReference ['position']),
//            'contact_name' => strtoupper($dataProfessionalReference ['contact_name']),
//            'contact_phone' => $dataProfessionalReference ['contact_phone'],
//            'contact_email' => $dataProfessionalReference ['contact_email'],
//        ]);
//
//        return response()->json([
//            'response' => $professionalReference,
//            'message' => 'successful'
//        ], 201);aaa
    }

    function destroy($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }

        $professionalReference = Reference::find($id)->first();

        if (!$professionalReference) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Referencia no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        $professionalReference->deleted();

        return response()->json([
            'data' => $professionalReference,
            'msg' => [
                'summary' => 'Referencia eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '200'
            ]], 200);
    }

}
