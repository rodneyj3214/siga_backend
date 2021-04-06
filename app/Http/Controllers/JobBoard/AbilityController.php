<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Ability;

class AbilityController extends Controller
{
    function index(Request $request)
    {
        $abilities = Ability::all();

        return response()->json([
            'data' => $abilities,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function show($id)
    {
        $ability = Ability::findOrFail($id);

        return response()->json([
            'data' => $ability,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function store(Request $request)
    {
        $data = $request->json()->all();
        $dataAbility = $data['ability'];

        $ability = new Ability();
        $ability->description = $dataAbility['description'];

        $ability->user()->associate($request->user());
        $ability->save();
    }

    function update(Request $request,$id)
    {
        $data = $request->json()->all();
        $dataAbility = $data['ability'];
        $dataCategory = $data['category'];

        $ability = Ability::findOrFail($id);
        $ability->description = $dataAbility['description'];

        $ability->professional()->associate(Professional::firstWhere('user_id',$request->user()->id));
//        $ability->category()->associate($dataCategory['category']);
        $ability->category()->associate(Category::findOrFail($dataCategory['id']));
        $ability->save();
    }

    function destroy($id)
    {
        $ability = Ability::findOrFail($id);
        $ability->state = false;
        $ability->save();
    }

    function validateDuplicate($dataAbility, $professional)
    {
        return Ability::where('category', $dataAbility['category'])
            ->where('professional_id', $professional['id'])
            ->where('state', '<>', 'DELETED')
            ->first();
    }
}
