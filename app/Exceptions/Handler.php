<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Exceptions\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof OAuthServerException) {
            // grant type is not supported
            if ($e->getCode() === 2) {
                return response()->json([
                    'data' => $e->getMessage(),
                    'msg' => [
                        'summary' => 'Tipo de autenticacion no soportado',
                        'detail' => 'Comnicate con el administrador',
                        'code' => $e->getCode()
                    ]], 400);
            }
            // client authentication failed
            if ($e->getCode() === 4) {
                return response()->json([
                    'data' => $e->getMessage(),
                    'msg' => [
                        'summary' => 'Cliente no valido',
                        'detail' => 'Comunicate con el administrador',
                       'code' => $e->getCode()
                    ]], 500);
            }
            // user authentication failed
            if ($e->getCode() === 10) {
                return response()->json([
                    'data' => $e->getMessage(),
                    'msg' => [
                        'summary' => 'Credenciales no validas',
                        'detail' => 'Su usuario o contraseña no son correctos',
                       'code' => $e->getCode()
                    ]], 401);
            }
        }

        if ($e instanceof AuthenticationException) {
            return response()->json([
                'data' => $e->getMessage(),
                'msg' => [
                    'summary' => 'No Autenticado',
                    'detail' => '',
                   'code' => $e->getCode()
                ]], 401);
        }

        if ($e instanceof HttpException) {
            return response()->json([
                'data' => $e->getMessage(),
                'msg' => [
                    'summary' => 'Recurso no encontrado',
                    'detail' => '',
                    'code' => $e->getCode()
                ]], 404);
        }

        if ($e instanceof QueryException) {
            return response()->json([
                'data' => $e->getMessage(),
                'msg' => [
                    'summary' => 'Error en la consulta',
                    'detail' => 'Comunicate con el administrador',
                    'code' => $e->getCode()
                ]], 400);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'data' => $e->getMessage(),
                'msg' => [
                    'summary' => 'Error en la consulta',
                    'detail' => 'Comunicate con el administrador',
                    'code' => $e->getCode()
                ]], 400);
        }

        if ($e instanceof ValidationException) {
            return response()->json([
                'data' => $e->errors(),
                'msg' => [
                    'summary' => 'Error en la validación de campos',
                    'detail' => $e->errors(),
                    'code' => $e->getCode()
                ]], 422);
        }

        if ($e instanceof \Error) {
            return response()->json([
                'data' => $e->getMessage(),
                'msg' => [
                    'summary' => 'Oops! Tuvimos un problema con el servidor',
                    'detail' => 'Comnicate con el administrador',
                   'code' => $e->getCode(),
                ]], 500);
        }

        return response()->json([
            'data' => $e->getMessage(),
            'msg' => [
                'summary' => $e->getMessage(),
                'detail' => 'Comnicate con el administrador',
                'code' => $e->getCode()
            ]], 500);
//        return parent::render($request, $e);
    }
}
