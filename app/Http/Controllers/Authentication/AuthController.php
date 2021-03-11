<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\Auth\AuthChangePasswordRequest;
use App\Http\Requests\Authentication\Auth\AuthForgotPasswordRequest;
use App\Http\Requests\Authentication\Auth\AuthLoginRequest;
use App\Http\Requests\Authentication\Auth\AuthResetPasswordRequest;
use App\Http\Requests\Authentication\Auth\AuthTransactionalCodeRequest;
use App\Http\Requests\Authentication\Auth\AuthUnlockRequest;
use App\Http\Requests\Authentication\Auth\AuthUnlockUserRequest;
use App\Models\Authentication\PasswordReset;
use App\Models\Authentication\PassworReset;
use App\Models\App\Status;
use App\Models\Authentication\System;
use App\Models\Authentication\TransactionalCode;
use App\Models\Authentication\UserUnlock;
use App\Models\Authentication\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class  AuthController extends Controller
{

    public function attempts($username)
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Usuario no encontrado',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
        $user->update(['attempts' => $user->attempts - 1]);
        if ($user->attempts <= 0) {
            $user->status()->associate(Status::where('code', $catalogues['status']['locked'])->first());
            $user->attempts = 0;
            $user->save();
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Oops! Su usuario ha sido bloqueado!',
                    'detail' => 'Demasiados intentos de inicio de sesión',
                    'code' => '429'
                ]], 429);
        }
        return response()->json(['data' => $user->attempts,
            'msg' => [
                'summary' => 'Contrasaña incorrecta',
                'detail' => 'Oops! te quedan ' . $user->attempts . ' intentos',
                'code' => '401',
            ]], 401);
    }

    public function resetAttempts($username)
    {
        $user = User::firstWhere('username', $username);

        if (!$user) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Usuario no encontrado',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
        $user->update(['attempts' => User::ATTEMPTS]);

        return response()->json(['data' => $user->attempts,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201',
            ]], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function logoutAll(Request $request)
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', $request->user_id)
            ->update([
                'revoked' => true
            ]);
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function changePassword(AuthChangePasswordRequest $request)
    {
        $data = $request->json()->all();
        $dataUser = $data['user'];
        $user = User::findOrFail($dataUser['id']);
        if (!$user) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Usuario no encontrando',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        if (!Hash::check(trim($dataUser['password']), $user->password)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'La contraseña actual no coincide con la enviada',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
        $user->update(['password' => Hash::make(trim($dataUser['new_password'])), 'change_password' => true]);
        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function forgotPassword(AuthForgotPasswordRequest $request)
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->orWhere('personal_email', $request->username)
            ->first();
        if (!$user) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Usuario no encontrando',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
        $token = Str::random(100);
        PasswordReset::create([
            'username' => $user->username,
            'token' => $token
        ]);
        $system = System::firstWhere('code', $catalogues['system']['code']);
        Mail::send('mails.forgot', ['token' => $token, 'user' => $user, 'system' => $system], function (Message $message) use ($user) {
            $message->to($user->email);
            $message->subject('Notificación de restablecimiento de contraseña');
        });
        $domainEmail = strlen($user->email) - strpos($user->email, "@");

        return response()->json([
            'data' => $this->hiddenString($user->email, 3, $domainEmail),
            'msg' => [
                'summary' => 'Correo enviado',
                'detail' => $this->hiddenString($user->email, 3, $domainEmail),
                'code' => '201'
            ]], 201);
    }

    public function unlockUser(AuthUnlockUserRequest $request)
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->orWhere('personal_email', $request->username)
            ->first();
        if (!$user) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Usuario no encontrando',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
        $token = Str::random(100);
        UserUnlock::create([
            'username' => $user->username,
            'token' => $token
        ]);

//        $data = ['token' => $token, 'user' => $user];
//        $pdf = \PDF::loadView('mails.unlock', $data);
        $system = System::firstWhere('code', $catalogues['system']['code']);

        Mail::send('mails.unlock', ['token' => $token, 'user' => $user, 'system' => $system],
            function (Message $message) use ($user) {
                $message->to($user->email);
                $message->subject('Notificación de desbloqueo de usuario');
//             $message->attachData($pdf->output(), 'test.pdf');
            });
        $domainEmail = strlen($user->email) - strpos($user->email, "@");

        return response()->json([
            'data' => $this->hiddenString($user->email, 3, $domainEmail),
            'msg' => [
                'summary' => 'Correo enviado',
                'detail' => $this->hiddenString($user->email, 3, $domainEmail),
                'code' => '201'
            ]], 201);
    }

    public function transactionalCode($username)
    {
        $user = User::where('username', $username)
            ->orWhere('email', $username)
            ->orWhere('personal_email', $username)
            ->first();
        if (!$user) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Usuario no encontrando',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
        $token = mt_rand(111111, 999999);
        TransactionalCode::create([
            'username' => $user->username,
            'token' => $token
        ]);


        Mail::send('mails.transactional-code', ['token' => $token, 'user' => $user], function (Message $message) use ($user) {
            $message->to($user->email);
            $message->subject('Información Código de Seguridad');
        });
        $domainEmail = strlen($user->email) - strpos($user->email, "@");

        return response()->json([
            'data' => $this->hiddenString($user->email, 3, $domainEmail),
            'msg' => [
                'summary' => 'Correo enviado',
                'detail' => $this->hiddenString($user->email, 3, $domainEmail),
                'code' => '201'
            ]], 201);
    }

    public function resetPassword(AuthResetPasswordRequest $request)
    {
        $passworReset = PasswordReset::where('token', $request->token)->first();
        if (!$passworReset) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Token no encontrado',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
        if (!$passworReset->is_valid) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Token no valido',
                    'detail' => 'El token ya fue utilizado',
                    'code' => '403'
                ]], 403);
        }
        if ((new Carbon($passworReset->created_at))->addMinutes(10) <= Carbon::now()) {
            $passworReset->update(['is_valid' => false]);
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Token no valido',
                    'detail' => 'El token ha expirado',
                    'code' => '403'
                ]], 403);
        }

        if (!$user = User::where('username', $passworReset->username)->first()) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Usuario no encontrado',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        $passworReset->update(['is_valid' => false]);
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Su contraseña fue restablecida',
                'detail' => 'Regrese al Login',
                'code' => '201'
            ]], 201);
    }

    public function unlock(AuthUnlockRequest $request)
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $userUnlock = UserUnlock::where('token', $request->token)->first();
        if (!$userUnlock) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Token no encontrado',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
        if (!$userUnlock->is_valid) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Token no valido',
                    'detail' => 'El token ya fue utilizado',
                    'code' => '403'
                ]], 403);
        }
        if ((new Carbon($userUnlock->created_at))->addMinutes(10) <= Carbon::now()) {
            $userUnlock->update(['is_valid' => false]);
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Token no valido',
                    'detail' => 'El token ha expirado',
                    'code' => '403'
                ]], 403);
        }

        if (!$user = User::where('username', $userUnlock->username)->first()) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Usuario no encontrado',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        $user->password = Hash::make($request->password);
        $user->status()->associate(Status::where('code', $catalogues['status']['active'])->first());
        $user->attempts = User::ATTEMPTS;
        $user->save();
        $userUnlock->update(['is_valid' => false]);
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Su usuario fue desbloqueado',
                'detail' => 'Regrese al Login',
                'code' => '201'
            ]], 201);
    }

    public function verifyTransactionalCode(AuthUnlockRequest $request)
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
        if ((new Carbon($transactionalCode->created_at))->addMinutes(2) <= Carbon::now()) {
            $transactionalCode->update(['is_valid' => false]);
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Código no válido',
                    'detail' => 'El código ha expirado',
                    'code' => '403'
                ]], 403);
        }

        if (!$user = User::where('username', $transactionalCode->username)->first()) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Usuario no encontrado',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        $transactionalCode->update(['is_valid' => false]);
        return response()->json([
            'data' => true,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    private function hiddenString($str, $start = 1, $end = 1)
    {
        $len = strlen($str);
        return substr($str, 0, $start) . str_repeat('*', $len - ($start + $end)) . substr($str, $len - $end, $end);
    }
}
