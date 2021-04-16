<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use App\Models\Authentication\User;
use App\Models\JobBoard\Reference;
use App\Models\JobBoard\Professional;

use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    function index(Request $request)
    {
        $professional = Professional::where('id', $request->user_id)->first();
        if (is_null($professional)){
            return response()->json([
                'response' => null,
                'message' => 'No existe ese dato.'
            ], 200);
        }

        if ($professional) {
            $professionalReferences = Reference::where('professional_id', $professional->id)
                ->where('state', 'ACTIVE')
                ->orderby($request->field, $request->order)
                ->paginate($request->limit);
            return response()->json([
                'pagination' => [
                    'total' => $professionalReferences->total(),
                    'current_page' => $professionalReferences->currentPage(),
                    'last_page' => $professionalReferences->lastPage(),
                    'from' => $professionalReferences->firstItem(),
                    'to' => $professionalReferences->lastItem()
                ], 'professionalReferences' => $professionalReferences], 200);
        } else {
            return response()->json([
                'pagination' => [
                    'total' => 0,
                    'current_page' => 1,
                    'last_page' => 1,
                    'from' => null,
                    'to' => null
                ], 'professionalReference' => null], 404);
        }
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
                    'summary' => 'Habilidad no encontrada',
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
        $data = $request->json()->all();
        $dataUser = $data['user'];
        $dataProfessionalReference = $data['professionalReference'];
        $professional = Professional::where('user_id', $dataUser['id'])->first();

        if ($professional) {
            $response = $professional->professionalReferences()->create([
                'institution' => strtoupper($dataProfessionalReference ['institution']),
                'position' => strtoupper($dataProfessionalReference ['position']),
                'contact_name' => strtoupper($dataProfessionalReference ['contact_name']),
                'contact_phone' => $dataProfessionalReference ['contact_phone'],
                'contact_email' => $dataProfessionalReference ['contact_email'],
            ]);
            return response()->json([
                'response' => $response,
                'message' => 'successful'
            ], 200);
        } else {
            return response()->json([
                'response' => null,
                'message' => 'successful'
            ], 404);
        }

    }

    function update(Request $request)
    {
        $data = $request->json()->all();

        $dataProfessionalReference = $data['professionalReference'];

        $professionalReference = Reference::findOrFail($dataProfessionalReference['id'])->update([
            'institution' => strtoupper($dataProfessionalReference ['institution']),
            'position' => strtoupper($dataProfessionalReference ['position']),
            'contact_name' => strtoupper($dataProfessionalReference ['contact_name']),
            'contact_phone' => $dataProfessionalReference ['contact_phone'],
            'contact_email' => $dataProfessionalReference ['contact_email'],
        ]);

        return response()->json([
            'response' => $professionalReference,
            'message' => 'successful'
        ], 201);
    }

    function destroy($id)
    {
        $professionalReference = Reference::findOrFail($id);
        $professionalReference->state = false;
        $professionalReference->save();
        return response()->json($professionalReference, 201);
    }

}
