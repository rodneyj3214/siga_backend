<?php

namespace App\Http\Controllers\JobBoard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobBoard\Professional;

use Exception;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests\JobBoard\Professional\IndexProfessionalRequest;

class ProfessionalController extends Controller
{
          function show($professionalId)
        {
            $professional = Professional::find($professionalId);
  if (!$professional){

    return response()->json([
        'data' => $professional ,
        'msg' => [
            'summary' => 'Profesional no encontrado',
            'detail' => 'Vuelva a intentar',
            'code' => '404',
        ]], 404);
         

  }
            return response()->json([
                'data' => $professional ,
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200',
                ]], 200);
                 
        }
    
        
        function update (Request $request, $id)
        {
 
            $professional = new Professional();
     //      $professional->user()->$dataProfessional['user_id'];
            $professional->has_travel = $request->input('professional.has_travel');
            $professional->has_license = $request->input('professional.has_license');
            $professional->has_disability = $request->input('professional.has_disability');
            $professional->has_familiar_disability = $request->input('professional.has_familiar_disability');
            $professional->identification_familiar_disability = $request->input('professional.identification_familiar_disability');
            $professional->has_catastrophic_illness = $request->input('professional.has_catastrophic_illness');
            $professional->familiar_catastrophic_illness = $request->input('professional.familiar_catastrophic_illness');
            $professional->about_me = $request->input('professional.about_me');

        
            $professional->user()->associate(User::findOrfail($request->input('user.id')));
            $professional->save();
     
            }

        function destroy($professionalId)
        {
            
            $professional = Professional::find($professionalId);
                if (!$professional) {
                    return response()->json([
                        'data' => null,
                        'msg' => [
                            'summary' => 'Professional no encontrado',
                            'detail' => 'Vuelva a intentar',
                            'code' => '404'
                        ]], 404);
                }
        $professional->delete();

            return response()->json([
                'data' => $professional ,
                'msg' => [
                    'summary' => 'Profesional eliminado',
                    'detail' => 'El registro fue eliminado',
                    'code' => '201'
                ]], 201);
                 
        }
       
    }   
    
