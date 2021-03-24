<?php

namespace App\Http\Controllers\Voting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\Auth\AuthUnlockRequest;
use App\Mail\AuthMailable;
use App\Mail\VotingMailable;
use App\Models\Authentication\System;
use App\Models\Authentication\TransactionalCode;
use App\Models\Authentication\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VotingController extends Controller
{
    public function getStudentInformation(Request $request)
    {
        $sql = "select i.id as institution_id,
       i.nombre as instituto,
       c.nombre as carrera,
       u.user_name as user_name,
       e.identificacion as identification,
       e.apellido1 as first_lastname,
       e.apellido2 as second_lastname,
       e.nombre1 as first_name,
       e.nombre2 as second_name,
       e.correo_institucional
from users u
         inner join estudiantes e on u.id = e.user_id
         inner join carrera_user cu on u.id = cu.user_id
         inner join carreras c on c.id = cu.carrera_id
         inner join institutos i on i.id = c.instituto_id
where u.user_name ='" . $request->user_name . "'";
        $user = DB::connection('pgsql-voting')->select($sql);
        return response()->json([
            'data' => $user[0],
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function vote(Request $request)
    {

    }

    public function getListsParticipants(Request $request)
    {
        $lists = "select
       vd.title,
       vd.description,
       vd.start_date,
       vd.end_date,
       vl.id,
       vl.name,
       vl.color
from voting_days vd
         inner join voting_lists vl on vd.id = vl.voting_day_id
where vd.voting_dayable_id = 1
  and type = 'ESTUDIANTE'
  and vd.status = 'ACTUAL';";
        $listsParticipants = "select  lp.*,
                        e.apellido1,
                        e.apellido2,
                        e.nombre1,
                        e.nombre2
                from voting_days vd inner join voting_lists vl on vd.id = vl.voting_day_id
                                inner join list_participants lp on vl.id = lp.voting_list_id
                                inner join users u on u.id = lp.user_id
                                inner join estudiantes e on u.id = e.user_id
                where vd.voting_dayable_id =" . $request->institution_id . " and vd.type ='" . $request->type . "' and vd.status = 'ACTUAL'
                order by lp.voting_list_id, lp.order;";

        $responseLists = DB::connection('pgsql-voting')->select($lists);
        $responseListsParticipants = DB::connection('pgsql-voting')->select($listsParticipants);
        $response = array();

        foreach ($responseLists as $list) {
            $existe = array_search($list->id, array_column($response, 'id'));
            if (!$existe) {
                array_push($response, $responseLists[$existe]);
            } else {
                $response[$existe] = $participant;
            }
            foreach ($responseListsParticipants as $participant) {
                $existe = array_search($list->id, array_column($response['participants'], 'id'));
                if (!$existe) {
                    array_push($response, $responseLists[$existe]);
                } else {
                    $response[$existe] = $participant;
                }
            }
        }

        return response()->json(['lists' => $response, 'participants' => $response], 200);
    }

    public function verifyUser(Request $request)
    {
        $sql = "select i.id,
       i.nombre as instituto,
       c.nombre as carrera,
       u.user_name as user_name,
       e.identificacion as identification,
       e.apellido1 as first_lastname,
       e.apellido2 as second_lastname,
       e.nombre1 as first_name,
       e.nombre2 as second_name,
       e.correo_institucional
from users u
         inner join estudiantes e on u.id = e.user_id
         inner join carrera_user cu on u.id = cu.user_id
         inner join carreras c on c.id = cu.carrera_id
         inner join institutos i on i.id = c.instituto_id
where u.user_name ='" . $request->identificacion . "'";

        $user = DB::connection('pgsql-voting')->select($sql);

        $user = $user[0];

        $token = Str::random(70);
        TransactionalCode::create([
            'username' => $user->user_name,
            'token' => $token
        ]);
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $system = System::firstWhere('code', $catalogues['system']['voting']);
        Mail::to($user->correo_institucional)
            ->send(new VotingMailable(
                'Votaciones - ' . $user->instituto,
                json_encode(['user' => $user, 'token' => $token]),
                null,
                $system
            ));
        return response()->json([
            'data' => $this->hiddenStringEmail($user->correo_institucional),
            'msg' => [
                'summary' => 'Correo enviado',
                'detail' => $this->hiddenStringEmail($user->correo_institucional),
                'code' => '201'
            ]], 201);
    }

    public function verifyTransactionalCode(Request $request)
    {
        $transactionalCode = TransactionalCode::where('token', $request->token)->first();
        if (!$transactionalCode) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Código no encontrado',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
        if (!$transactionalCode->is_valid) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Código no valido',
                    'detail' => 'El código ya fue utilizado',
                    'code' => '403'
                ]], 403);
        }
        if ((new Carbon($transactionalCode->created_at))->addMinutes(30) <= Carbon::now()) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Código no válido',
                    'detail' => 'El código ha expirado',
                    'code' => '403'
                ]], 403);
        }

//        $transactionalCode->update(['is_valid' => false]);


        return response()->json([
            'data' => true,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    private function hiddenStringEmail($email, $start = 5)
    {
        $end = strlen($email) - strpos($email, "@");
        $len = strlen($email);
        return substr($email, 0, $start) . str_repeat('*', $len - ($start + $end)) . substr($email, $len - $end, $end);
    }
}
