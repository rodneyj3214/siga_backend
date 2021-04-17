<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;

//Models
use App\Models\App\Catalogue;
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Ability;

//Validation Request
use App\Http\Requests\JobBoard\Ability\CreateAbilityRequest;
use App\Http\Requests\JobBoard\Ability\IndexAbilityRequest;
use App\Http\Requests\JobBoard\Ability\UpdateAbilityRequest;


class AbilityController extends Controller
{
    public function __construct(){

    }

    function index(IndexAbilityRequest $request)
    {
        $abilities = Ability::all();
        return response()->json([
            'data' => $abilities,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function show($abilityId)
    {
        $ability = Ability::find($abilityId);
        if (!$ability) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Abilidad no encontrada',
                    'detail' => 'Vuelva a intentar'
                ]], 404);
        }
        return response()->json([
            'data' => $ability,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function store(CreateAbilityRequest $request)
    {
        $ability = new Ability();
        $ability->description = $request->input('ability.description');
        $ability->professional()->associate(Professional::findOrFail($request->input('professional.id')));
        $ability->type()->associate(Catalogue::findOrFail($request->input('type.id')));
        $ability->save();

        return response()->json([
            'data' => $ability,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 201);
    }

    function update(UpdateAbilityRequest $request, $abilityId)
    {
        $ability = Ability::findOrFail($abilityId);
        $ability->description = $request->input('ability.description');

        $ability->professional()->associate(Professional::firstWhere($request->input('professional.id')));
        $ability->type()->associate(Catalogue::findOrFail($request->input('type.id')));
        $ability->save();

        return response()->json([
            'data' => $ability,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 201);
    }

    function destroy($abilityId)
    {
        $ability = Ability::find($abilityId);
        if (!$ability) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Abilidad no encontrada',
                    'detail' => 'Vuelva a intentar'
                ]], 404);
        }
        $ability->state = false;
        
        $ability->save();

        return response()->json([
            'data' => $ability,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 201);
    }

    function validateDuplicate($dataAbility, $professional)
    {
        return Ability::where('category', $dataAbility['category'])
            ->where('professional_id', $professional['id'])
            ->where('state', '<>', 'DELETED')
            ->first();
    }
}
