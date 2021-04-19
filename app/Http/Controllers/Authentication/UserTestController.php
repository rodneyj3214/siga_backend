<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Authentication\User;
use App\Models\App\Status;
use Illuminate\Http\Request;




class UserTestController extends Controller
{
    function index(Request $request)
    {
        $user = User::all();
        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function store(Request $request){

        $data = $request->json()->all();
        $dataUser = $data['user'];
        $dataStatus = $data['status'];

        $user = new User();
        $user->username = $dataUser['username'];
        $user->identification = $dataUser['identification'];
        $user->first_name = $dataUser['first_name'];
        $user->second_name = $dataUser['second_name'];
        $user->first_lastname = $dataUser['first_lastname'];
        $user->second_lastname = $dataUser['second_lastname'];
        $user->password = Hash::make(trim($dataUser['password']));
        $user->personal_email = $dataUser['personal_email'];
        $user->birthdate = $dataUser['birthdate'];
        $user->email = $dataUser['email'];

        $user->status()->associate(Status::findOrFail($dataStatus['id']));
        $user->save();
        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    function update(Request $request,$id){

        $data = $request->json()->all();
        $dataUser = $data['user'];
        $dataStatus = $data['status'];

        $user = User::findOrFail($id);
        $user->username = $dataUser['username'];
        $user->identification = $dataUser['identification'];
        $user->first_name = $dataUser['first_name'];
        $user->second_name = $dataUser['second_name'];
        $user->first_lastname = $dataUser['first_lastname'];
        $user->second_lastname = $dataUser['second_lastname'];
        $user->personal_email = $dataUser['personal_email'];
        $user->birthdate = $dataUser['birthdate'];
        $user->email = $dataUser['email'];

        $user->status()->associate(Status::findOrFail($dataStatus['id']));
        $user->save();
        return response()->json([
            'msg' => [
                'summary' => 'update',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    function destroy($id){
        
        $user = User::findOrFail($id);
        $user->state = false;
        $user->save();
        return response()->json([
            'msg' => [
                'summary' => 'deleted',
                'detail' => '',
                'code' => '201'
            ]], 201); 
    }

}
