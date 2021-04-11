<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use App\Models\JobBoard\Category;
use Illuminate\Http\Request;

use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Language;

class LanguageController extends Controller
{
    function index(Request $request)
    {
        $languages = Language::all();

        return response()->json([
            'data' => $languages,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function show($id)
    {
        $language = Language::findOrFail($id);

        return response()->json([
            'data' => $language,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function store(Request $request)
    {

        $data = $request->json()->all();
        $dataLanguage = $data['language'];
        $dataCategory = $data['category'];

        $language = new Language();
        $language->description = $dataLanguage['description'];

        $language->professional()->associate(Professional::firstWhere('user_id',$request->user()->id));
        $language->category()->associate(Category::findOrFail($dataCategory['id']));

        $language->save();
    }

    function update(Request $request,$id)
    {
        $data = $request->json()->all();
        $dataLanguage = $data['language'];
        $dataCategory = $data['category'];

        $language = Language::findOrFail($id);
        $language->description = $dataLanguage['description'];

        $language->professional()->associate(Professional::firstWhere('user_id',$request->user()->id));
        $language->category()->associate(Category::findOrFail($dataCategory['id']));
        $language->save();
    }

    function destroy($id)
    {
        $language = Language::findOrFail($id);
        $language->state = false;
        $language->save();
    }

    function validateDuplicate($dataLanguage, $professional)
    {
        return Language::where('category', $dataLanguage['category'])
            ->where('professional_id', $professional['id'])
            ->where('state', '<>', 'DELETED')
            ->first();
    }
}
