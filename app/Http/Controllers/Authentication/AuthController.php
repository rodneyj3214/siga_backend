<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\Auth\AuthChangePasswordRequest;
use App\Http\Requests\Authentication\Auth\AuthForgotPasswordRequest;
use App\Http\Requests\Authentication\Auth\AuthResetPasswordRequest;
use App\Http\Requests\Authentication\Auth\AuthUnlockRequest;
use App\Http\Requests\Authentication\Auth\AuthUnlockUserRequest;
use App\Mail\AuthMailable;
use App\Mail\EmailMailable;
use App\Models\Authentication\Client;
use App\Models\Authentication\PasswordReset;
use App\Models\App\Status;
use App\Models\Authentication\TransactionalCode;
use App\Models\Authentication\UserUnlock;
use App\Models\Authentication\User;
use App\Models\Authentication\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class  AuthController extends Controller
{

    public function attempts($username){
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

    public function resetAttempts($username){
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

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function logoutAll(Request $request){
        DB::table('oauth_access_tokens')
            ->where('user_id', $request->input('user_id'))
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

    public function changePassword(AuthChangePasswordRequest $request){
        $user = User::findOrFail($request->input('user.id'));
        if (!$user) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Usuario no encontrando',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
        if (!Hash::check(trim($request->input('user.password')), $user->password)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'La contraseña actual no coincide con la enviada',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
        $user->update(['password' => Hash::make(trim($request->input('user.new_password'))), 'change_password' => true]);
        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function forgotPassword(AuthForgotPasswordRequest $request){
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $user = User::where('username', $request->input('username'))
            ->orWhere('email', $request->input('username'))
            ->orWhere('personal_email', $request->input('username'))
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

        Mail::to($user->email)
            ->send(new EmailMailable(
                'Notificación de restablecimiento de contraseña',
                json_encode(['user' => $user, 'token' => $token])
            ));
        $domainEmail = strlen($user->email) - strpos($user->email, "@");

        return response()->json([
            'data' => $this->hiddenString($user->email, 3, $domainEmail),
            'msg' => [
                'summary' => 'Correo enviado',
                'detail' => $this->hiddenString($user->email, 3, $domainEmail),
                'code' => '201'
            ]], 201);
    }

    public function unlockUser(AuthUnlockUserRequest $request){
        $user = User::where('username', $request->input('username'))
            ->orWhere('email', $request->input('username'))
            ->orWhere('personal_email', $request->input('username'))
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
        $token = Str::random(70);
        UserUnlock::create([
            'username' => $user->username,
            'token' => $token
        ]);

        Mail::to($user->email)
            ->send(new AuthMailable(
                'Notificación de desbloqueo de usuario',
                json_encode(['user' => $user, 'token' => $token])
            ));

        return response()->json([
            'data' => $this->hiddenStringEmail($user->email),
            'msg' => [
                'summary' => 'Correo enviado',
                'detail' => $this->hiddenStringEmail($user->email),
                'code' => '201'
            ]], 201);
    }

    public function transactionalCode($username){
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

        Mail::to($user->email)
            ->send(new EmailMailable(
                'Información Código de Seguridad',
                json_encode(['user' => $user])
            ));
        $domainEmail = strlen($user->email) - strpos($user->email, "@");

        return response()->json([
            'data' => $this->hiddenString($user->email, 3, $domainEmail),
            'msg' => [
                'summary' => 'Correo enviado',
                'detail' => $this->hiddenString($user->email, 3, $domainEmail),
                'code' => '201'
            ]], 201);
    }

    public function resetPassword(AuthResetPasswordRequest $request){
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

    public function unlock(AuthUnlockRequest $request){
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

    public function verifyTransactionalCode(AuthUnlockRequest $request){
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

    private function hiddenStringEmail($email, $start = 3){
        $end = strlen($email) - strpos($email, "@");
        $len = strlen($email);
        return substr($email, 0, $start) . str_repeat('*', $len - ($start + $end)) . substr($email, $len - $end, $end);
    }

    public function getRoles(Request $request){
        $user = User::findOrFail($request->input('user'));

        $roles = $user->roles()->with('system')
            ->where('institution_id', $request->input('institution'))
            ->get();
        return response()->json([
            'data' => $roles,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function getPermissions(Request $request){
        $role = Role::findOrFail($request->input('role'));

        $permissions = $role->permissions()
            ->with(['route' => function ($route) {
                $route->with('module')->with('type')->with('status');
            }])
            ->with('institution')
            ->where('institution_id', $request->input('institution'))
            ->get();
        return response()->json([
            'data' => $permissions,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }
}
