<?php
use Illuminate\Support\Facades\Route;
Route::group([
	'middleware' => 'api',
	'prefix'     => 'auth',
], function ($router) {
	Route::post('login', 'AuthController@login');
	Route::post('logout', 'AuthController@logout');
	Route::post('refresh', 'AuthController@refresh');
	Route::post('me', 'AuthController@userProfile');
});
Route::group(['middleware' => ['jwt.verify','cors']], function () {
	Route::Apiresource('usuarios', UsuarioController::class, ['except' => ['create', 'edit']]);
	Route::get('user', 'UsuarioController@getAuthenticatedUser');
	Route::Apiresource('roles', RolController::class, ['except' => ['create', 'edit']]);
	Route::Apiresource('permisos', PermisoController::class, ['except' => ['create', 'edit']]);
	Route::post('update-password', 'UsuarioController@updatePassUsuario');
	Route::post('suspend-account', 'UsuarioController@BloquearUsuario');
	Route::post('reset-password', 'UsuarioController@ResetPassword');
	# Verifica si existe un email, antes de crear un usuario
    Route::post('verify-email', 'UsuarioController@verifyEmailExist');
});
Route::get('/clear-cache', function () {
	Artisan::call('cache:clear');
	return "Cache is cleared";
});
