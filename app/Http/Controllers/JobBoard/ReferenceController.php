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
        $professional = Professional::where('id', $request->user_id)->first();
        if ($professional) {
            $professionalReferences = Reference::where('professional_id', $professional->id)
                ->where('state', 'ACTIVE')
                ->orderby($request->field, $request->order)
                ->paginate($request->limit);
            return response()->json([
                'pagination' => [
                    'total' => $professionalReferences->total(),
                    'current_page' => $professionalReferences->currentPage(),
                    'per_page' => $professionalReferences->perPage(),
                    'last_page' => $professionalReferences->lastPage(),
                    'from' => $professionalReferences->firstItem(),
                    'to' => $professionalReferences->lastItem()
                ], 'professionalReferences' => $professionalReferences], 200);
        } else {
            return response()->json([
                'pagination' => [
                    'total' => 0,
                    'current_page' => 1,
                    'per_page' => $request->limit,
                    'last_page' => 1,
                    'from' => null,
                    'to' => null
                ], 'professionalReference' => null], 404);
        }
    }

    function show($id)
    {
        $professionalReference = Reference::findOrFail($id);
        return response()->json(['professionalReference' => $professionalReference], 200);
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
            ]);
            return response()->json($response, 201);
        } else {
            return response()->json(null, 404);
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
        ]);
        return response()->json($professionalReference, 201);
    }

    function destroy($id)
    {
        $professionalReference = Reference::findOrFail($id);
        $professionalReference->state = false;
        $professionalReference->save();
        return response()->json($professionalReference, 201);
    }

}
