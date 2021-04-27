<?php

namespace App\Http\Controllers\Authentication;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\User\UserCreateRequest;
use App\Http\Requests\Authentication\UserAdministration\IndexUserAdministrationRequest;
use App\Http\Requests\Authentication\UserRequest;
use App\Models\Authentication\PassworReset;
use App\Models\Authentication\Role;
use App\Models\App\Catalogue;
use App\Models\Authentication\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class  UserAdministrationController extends Controller
{ 
    public function index(IndexUserAdministrationRequest $request)
    {
       
    }

    public function show($username, Request $request)
    {
        $user = User::
            with(['institutions' => function ($institutions) {
                $institutions->orderBy('name');
            }])
            ->with(['roles' => function ($roles) use ($request) {
                $roles
                    ->with(['permissions' => function ($permissions) {
                        $permissions->with(['route' => function ($route) {
                            $route->with('module')->with('type')->with('status');
                        }])->with('institution');
                    }]);
            }])
            ->where('username', $username)
            ->first();

        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function store(UserCreateRequest $request)
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $data = $request->json()->all();
        $dataUser = $data['user'];
        $user = new User();

        $user->identification = strtoupper(trim($dataUser['identification']));
        $user->username = trim($dataUser['username']);
        $user->first_name = $catalogues['catalogue']['civil_status']['married'];
        $user->first_lastname = strtoupper(trim($dataUser['first_lastname']));
        $user->birthdate = trim($dataUser['birthdate']);
        $user->email = strtolower(trim($dataUser['email']));
        $user->password = Hash::make(trim($dataUser['password']));

        $ethnicOrigin = Catalogue::findOrFail($dataUser['ethnic_origin']['id']);
        $location = Catalogue::findOrFail($dataUser['location']['id']);
        $identificationType = Catalogue::findOrFail($dataUser['identification_type']['id']);
        $sex = Catalogue::findOrFail($dataUser['sex']['id']);
        $gender = Catalogue::findOrFail($dataUser['gender']['id']);
        $user->ethnicOrigin()->associate($ethnicOrigin);
        $user->address()->associate($location);
        $user->identificationType()->associate($identificationType);
        $user->sex()->associate($sex);
        $user->gender()->associate($gender);
        $user->save();
        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function update(Request $request,$userId)
    {
        $data = $request->json()->all();
        $dataUser = $data['user'];
        $user = User::find($userId);

        $user->identification = $dataUser['identification'];
        $user->username = strtoupper(trim($dataUser['username']));
        $user->first_name = strtoupper(trim($dataUser['first_name']));
        $user->first_lastname = strtoupper(trim($dataUser['first_lastname']));
        $user->birthdate = trim($dataUser['birthdate']);
        $user->email = strtolower(trim($dataUser['email']));
        $user->phone = strtolower(trim($dataUser['email']));

        $user->save();
        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'update',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function destroy($userId)
    {
        $user = User::find($userId);
        $user->delete();

        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'deleted',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    private function filter($conditions)
    {
        $filters = array();
        foreach ($conditions as $condition) {
            if ($condition['match_mode'] === 'contains') {
                array_push($filters, array($condition['field'], $condition['logic_operator'], '%' . $condition['value'] . '%'));
            }
            if ($condition['match_mode'] === 'start') {
                array_push($filters, array($condition['field'], $condition['logic_operator'], $condition['value'] . '%'));
            }
            if ($condition['match_mode'] === 'end') {
                array_push($filters, array($condition['field'], $condition['logic_operator'], '%' . $condition['value']));
            }
        }
        return $filters;
    }
}
