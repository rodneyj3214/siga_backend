<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JobBoard\Category;
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Ability;

class AbilityController extends Controller
{
    public function __construct(){

    }

    function index(Request $request, $professionalId)
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
        return "metodo show";
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

    function store(Request $request)
    {
<<<<<<< HEAD
        $data = $request->json()->all();
        $dataAbility = $data['ability'];
        $dataCategory = $data['category'];

=======
>>>>>>> 29d062f6e3c07c70e790050f46321454097a073d
        $ability = new Ability();
        $ability->description = $request->input('ability.description');

        $ability->professional()->associate(Professional::firstWhere('user_id', $request->user()->id));
        $ability->category()->associate(Category::findOrFail($request->input('category.id')));
        $ability->save();
    }

<<<<<<< HEAD
    function update(Request $request, $id)
=======
    function update(Request $request, $professionalId, $abilityId)
>>>>>>> 29d062f6e3c07c70e790050f46321454097a073d
    {
//        return $professionalId;
        return $abilityId;
        $data = $request->json()->all();
        $dataAbility = $data['ability'];
        $dataCategory = $data['category'];

        $ability = Ability::findOrFail($abilityId);
        $ability->description = $dataAbility['description'];

        $ability->professional()->associate(Professional::firstWhere('user_id', $request->user()->id));
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

    function test(Request $request)
    {
        return "hola mundo";
    }
}
