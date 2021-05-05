<?php

namespace App\Http\Controllers\JobBoard;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\JobBoard\Company;
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Offer;
use App\Models\JobBoard\Category;

use Illuminate\Http\Request;

class WebProfessionalController extends Controller
{
    function total()
    {
        $totalCompanies = Company::all()->count();
        $totalProfessionals = Professional::all()->count();
        $toalOffers = Offer::all()->count();

        return response()->json([
            'data' => [
                'totalCompanies' => $totalCompanies,
                'totalProfessionals' => $totalProfessionals,
                'totalOffers' => $toalOffers
            ],
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    // Devuelve un array de objetos y paginados
    function postulants(Request $request)
    {
        $offer = Offer::getInstance($request->id);

        $offer->professionals()->get();

        $professionals = Professional::with(['academicFormations' => function ($query) {
            $query->with('category');
        }])->paginate($request->input('per_page'));

        $professionals = Professional::with(['academicFormations' => function ($academicFormations) use($request) {
            $academicFormations->with(['category' => function ($category) use ($request) {
                $category->with(['parent'])->whereIn('id', $request->ids);
            }]);
        }])->paginate($request->input('per_page'));

        $professionals = Professional::with(['academicFormations' => function ($academicFormations) use($request) {
            $academicFormations->with(['category' => function ($category) use ($request) {
                $category->with(['parent'])->whereIn('parent_id', $request->parent_ids);
            }]);
        }])->paginate($request->input('per_page'));

        // $professionals = Professional::with(['academicFormations' => function($query){
        //     $query->with('category')->where('name', 'ilike', '%' . $request->search . '%');
        // }])->paginate($request->input('per_page'));

        // if (sizeof($professionals) === 0) {
        //     return response()->json([
        //         'data' => null,
        //         'msg' => [
        //             'summary' => 'No se encontraron Profesionales',
        //             'detail' => 'Intente de nuevo',
        //             'code' => '404'
        //         ]
        //     ], 404);
        // }

        return response()->json($professionals, 200);
    }

    function categories(Request $request)
    {
        // $categories = Category::with('children')->whereNull('parent_id')->get();
        // $categories = Category::with('children')->where('parent_id', null)->where('name', 'ilike', '%' . $request->input('search') . '%')->get();
        $categories = Category::with(['children' => function ($query) {
            $query->where('name', 'ilike', '%Pariatur aspernatur nihil rerum vitae nemo eos.%')->Orwhere('code', 'ilike', '%et%');
        }])->where('parent_id', null)->get();

        return response()->json($categories, 200);
    }
}
