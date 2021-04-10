<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;

// Models
use App\Models\App\Catalogue;
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Skill;

// Request Validation
use App\Http\Requests\JobBoard\Skill\CreateSkillRequest;
use App\Http\Requests\JobBoard\Skill\IndexSkillRequest;
use App\Http\Requests\JobBoard\Skill\UpdateSkillRequest;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    function index(IndexSkillRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
        $professional = Professional::getInstance($request->input('professional_id'));

        if ($request->has('search')) {
            $skills = $professional->skills()
                ->description($request->input('search'))
                ->get();
        } else {
            $skills = $professional->skills()->paginate($request->input('per_page'));
        }

        if (sizeof($skills) === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Habilidades',
                    'detail' => 'Intente de nuevo',
                    'code'=>'404'
                ]], 404);
        }

        return response()->json($skills, 200);
    }

    function show($skillId)
    {
        // Valida que el id se un número, si no es un número devuelve un mensaje de error
        if (!is_numeric($skillId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo',
                    'code'=>'400'
                ]], 400);
        }
        $skill = Skill::find($skillId);

        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$skill) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Habilidad no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code'=>'404'
                ]], 404);
        }


        return response()->json([
            'data' => $skill,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code'=>'200'
            ]], 200);
    }

    function store(CreateSkillRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
        $professional = Professional::getInstance($request->input('professional.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        $type = Catalogue::getInstance($request->input('type.id'));

        $skill = new Skill();
        $skill->description = $request->input('skill.description');
        $skill->professional()->associate($professional);
        $skill->type()->associate($type);
        $skill->save();

        return response()->json([
            'data' => $skill,
            'msg' => [
                'summary' => 'Habilidad creada',
                'detail' => 'El registro fue creado',
                'code'=>'400'
            ]], 201);
    }

    function update(UpdateSkillRequest $request, $skillId)
    {
        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        $type = Catalogue::getInstance($request->input('type.id'));

        $skill = Skill::find($skillId);

        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$skill) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Habilidad no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code'=>'404'
                ]], 404);
        }

        $skill->description = $request->input('skill.description');
        $skill->type()->associate($type);
        $skill->save();

        return response()->json([
            'data' => $skill,
            'msg' => [
                'summary' => 'Habilidad actualizada',
                'detail' => 'El registro fue actualizado',
                'code'=>'201'
            ]], 201);
    }

    function destroy($skillId)
    {
        // Valida que el id se un número, si no es un número devuelve un mensaje de error
        if (!is_numeric($skillId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo',
                    'code'=>'400'
                ]], 400);
        }
        $skill = Skill::find($skillId);

        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$skill) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Habilidad no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code'=>'404'
                ]], 404);
        }

        // Es una eliminación lógica
        $skill->state = false;
        $skill->save();

        return response()->json([
            'data' => $skill,
            'msg' => [
                'summary' => 'Habilidad eliminada',
                'detail' => 'El registro fue eliminado',
                'code'=>'201'
            ]], 201);
    }

    function test(Request $request)
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $types = Catalogue::where('type', $catalogues['catalogue']['company_type']['type'])->get();
        $activityTypes = Catalogue::where('type', $catalogues['catalogue']['company_activity_type']['type'])->get();
        $personTypes = Catalogue::where('type', $catalogues['catalogue']['company_person_type']['type'])->get();
        return response()->json($types[rand(1, 4)]['id'], 200);
    }
}