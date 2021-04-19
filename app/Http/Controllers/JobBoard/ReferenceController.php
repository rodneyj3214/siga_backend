<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobBoard\Reference\CreateReferenceRequest;
use App\Http\Requests\JobBoard\Reference\IndexReferenceRequest;
use App\Http\Requests\JobBoard\Reference\UpdateReferenceRequest;
use App\Models\JobBoard\Reference;
use App\Models\JobBoard\Professional;

use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    function index(IndexReferenceRequest $request)
    {
        $professional = Professional::getInstance($request->input('professional_id'));

        if ($request->has('search')) {
            $references = $professional->professionalReferences()
                ->institution($request->input('search'))
                ->position($request->input('search'))
                ->contacName($request->input('search'))
                ->contacPhone($request->input('search'))
                ->contacEmail($request->input('search'))
                ->get();
        } else {
            $references = $professional->professionalReferences()->paginate($request->input('per_page'));
        }

        if (sizeof($references) === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Referencias',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        return response()->json($references, 200);
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

    function store(CreateReferenceRequest $request)
    {
        $professional = Professional::getInstance($request->input('professional.id'));

        $reference = new Reference();
        $reference->professional()->associate($professional);
        $reference->institution = $request->input('reference.institution');
        $reference->position = $request->input('reference.position');
        $reference->contact_name = $request->input('reference.contact_name');
        $reference->contact_phone = $request->input('reference.contact_phone');
        $reference->contact_email = $request->input('reference.contact_email');

        $reference->save();

        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'Referencia creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    function update(UpdateReferenceRequest $request, $id)
    {
        $reference = Reference::find($id);

        if (!$reference) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Referencia no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        $reference->institution = $request->input('reference.institution');
        $reference->position = $request->input('reference.position');
        $reference->contact_name = $request->input('reference.contact_name');
        $reference->contact_phone = $request->input('reference.contact_phone');
        $reference->contact_email = $request->input('reference.contact_email');

        $reference->update();

        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'Referencia actualizada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
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

        $professionalReference = Reference::find($id);

        if (!$professionalReference) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Referencia no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        $professionalReference->delete();

        return response()->json([
            'data' => $professionalReference,
            'msg' => [
                'summary' => 'Referencia eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '200'
            ]], 200);
    }

}
