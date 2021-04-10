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
                    'detail' => 'Intente de nuevo'
                ]], 404);
        }

        return response()->json($skills, 200);
    }

    function show($skillId)
    {
        if (!is_numeric($skillId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo'
                ]], 400);
        }
        $skill = Skill::find($skillId);
        if (!$skill) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Habilidad no encontrada',
                    'detail' => 'Vuelva a intentar'
                ]], 404);
        }
        return response()->json([
            'data' => $skill,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function store(CreateSkillRequest $request)
    {
        $professional = Professional::getInstance($request->input('professional.id'));
        $type = Catalogue::getInstance($request->input('type.id'));

        $skill = new Skill();
        $skill->description = $request->input('skill.description');
        $skill->professional()->associate($professional);
        $skill->type()->associate($type);
        $skill->save();

        return response()->json([
            'data' => $skill,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 201);
    }

    function update(UpdateSkillRequest $request, $skillId)
    {
        $type = Catalogue::getInstance($request->input('type.id'));

        $skill = Skill::find($skillId);
        if (!$skill) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Habilidad no encontrada',
                    'detail' => 'Vuelva a intentar'
                ]], 404);
        }

        $skill->description = $request->input('skill.description');
        $skill->type()->associate($type);
        $skill->save();

        return response()->json([
            'data' => $skill,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 201);
    }

    function destroy($skillId)
    {
        if (!is_numeric($skillId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo'
                ]], 400);
        }
        $skill = Skill::find($skillId);
        if (!$skill) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Habilidad no encontrada',
                    'detail' => 'Vuelva a intentar'
                ]], 404);
        }
        $skill->state = false;
        $skill->save();

        return response()->json([
            'data' => $skill,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 201);
    }

    function validateDuplicate($dataSkill, $professional)
    {
        return Skill::where('category', $dataSkill['category'])
            ->where('professional_id', $professional['id'])
            ->where('state', '<>', 'DELETED')
            ->first();
    }

    function test(Request $request)
    {
        return response()->json(csrf_token());
        $professional = new Professional();
        $professional->id = $request->input('professional_id');
        $skills = $professional->skills()->paginate($request->input('per_page'));
        return response()->json($skills, 200);
    }
}
