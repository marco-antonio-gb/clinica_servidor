<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class UsuarioController extends Controller {
	public function __construct() {
		$this->middleware('jwt.auth');
	}
	public function index() {
		// $usuarios = Usuario::with('roles')->get();
		// return $usuarios;
		try {
			$result = Usuario::with('roles')->with('persona')->get();
			if (!$result->isEmpty()) {
				return response()->json([
					'success' => true,
					'data'    => $result,
				], 200);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'No existen resultados',
				], 204);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function store(Request $request) {
		try {
			$validator = Validator::make($request->all(), [
				'nombres' => 'required|string|between:2,100',
				'ci'      => 'required|between:2,15',
				'ci_ext'  => 'required|between:2,15',
				'celular' => 'required|string|max:9',
				'cargo'   => 'required|string|max:100',
				'email'   => 'required|string|email|max:100|unique:usuarios',
			]);
			if ($validator->fails()) {
				return response()->json([
					'success'     => false,
					'validator'   => $validator->errors()->all(),
					'status_code' => 400,
				]);
			}
			$user = [
				"paterno"   => $request['paterno'],
				"materno"   => $request['materno'],
				"nombres"   => $request['nombres'],
				"ci"        => $request['ci'],
				"ci_ext"    => $request['ci_ext'],
				"direccion" => $request['direccion'],
				"telefono"  => $request['telefono'],
				"celular"   => $request['celular'],
				"cargo"     => $request['cargo'],
				"email"     => $request['email'],
				'password'  => bcrypt($request->password),
				"settings"  => json_encode($request['settings']),
			];
			$user = Usuario::create($user);
			$user->assignRole($request['roles']);
			return response()->json([
				'success'     => true,
				'message'     => "Usuario registrado correctamente",
				'status_code' => 201,
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function show($id) {
		try {
//            $roles = Usuario::join('roles','roles.idRol')
			$usuario = Usuario::where('idUsuario', '=', $id)->with('persona')->with('permissions')->first();
			$usuario->setAttribute('roles', getAllRoles($id));
			$usuario->setAttribute('permisos', getAllPermissions($id));
			if ($usuario) {
				return [
					'success'     => true,
					'data'        => $usuario,
					'status_code' => 200,
				];
			} else {
				return [
					'success'     => false,
					'message'     => 'No se encontro ningun registro',
					'status_code' => 204,
				];
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function update(Request $request, $id) {

		try {
			$validator = Validator::make($request->all(), [
				'paterno' => 'required|string|between:2,100',
				'materno' => 'required|string|between:2,100',
				'nombres' => 'required|string|between:2,100',
				'ci'      => 'required|string|max:15',
				'ci_ext'  => 'required|string|max:10',
				'celular' => 'required|string|max:10',
				'cargo'   => 'required|string|max:50',
				'email'   => 'required|string|email|max:100',
			]);
			if ($validator->fails()) {
				return response()->json([
					'success'     => false,
					'validator'   => $validator->errors()->all(),
					'status_code' => 400,
				]);
			} else {
			}
			$user           = Usuario::find($id);
			$user->paterno  = $request['paterno'];
			$user->materno  = $request['materno'];
			$user->nombres  = $request['nombres'];
			$user->ci       = $request['ci'];
			$user->ci_ext   = $request['ci_ext'];
			$user->celular  = $request['celular'];
			$user->telefono = $request['telefono'];
			$user->cargo    = $request['cargo'];
			$user->email    = $request['email'];
			$user->save();
			$roles = $request['roles'];
			foreach ($roles as $key => $value) {
				if (is_string($value)) {
					$names[] = $value;
				} else {
					$names[] = $value['name'];
				}
			}
			$user->syncRoles($names);
			return response()->json([
				'success' => true,
				'message' => 'Usuario Actualizado correctamente',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function destroy($id) {
		try {
			Usuario::where('idUsuario', '=', $id)->delete();
			return response()->json([
				'success' => true,
				'message' => 'Rol eliminado correctamente',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function getAuthenticatedUser() {
		try {
			if (!$user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['token_expired'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(['token_invalid'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json(['token_absent'], $e->getStatusCode());
		}
		return response()->json(compact('user'));
	}
	/*---------------------   CUSTOM FUNCTIONS -------------------------*/
	public function verifiEmailExist(Request $request) {
		try {
			if (Usuario::where('email', '=', $request['email'])->exists()) {
				return response()->json([
					'success' => true,
					'message' => "El correo ya existe, seleccione otro",
				], 404);
			} else {
				return response()->json([
					'success' => false,
					'message' => "El correo esta disponible",
				], 200);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function updatePassUsuario(Request $request) {
		try {
			$this->validate($request, [
				'old_password' => 'required',
				'new_password' => 'required',
			]);
			$hashedPassword = Auth::user()->password;
			if (\Hash::check($request->old_password, $hashedPassword)) {
				if (!\Hash::check($request->new_password, $hashedPassword)) {
					$users           = Usuario::find(Auth::user()->idUsuario);
					$users->password = bcrypt($request->new_password);
					Usuario::where('idUsuario', Auth::user()->idUsuario)->update(array('password' => $users->password));
					return response()->json([
						'success' => true,
						'message' => "Contrase??a actualizada exitosamente",
					], 201);
				} else {
					return response()->json([
						'success' => false,
						'message' => "??La nueva contrase??a no puede ser la contrase??a anterior!",
					], 404);
				}
			} else {
				return response()->json([
					'success' => false,
					'message' => "La contrase??a anterior no coincide",
				], 404);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}
	public function ResetPassword(Request $request) {
		try {
			$hashed_random_password = generateStrongPassword(15, false, 'luds');
			Usuario::where('idUsuario', '=', $request['userId'])->update(['password' => Hash::make($hashed_random_password)]);
			return response()->json([
				'success'     => true,
				'message'     => "La contrase??a se restablecio",
				'newPassword' => $hashed_random_password,
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}
	public function BloquearUsuario(Request $request) {
		try {
			if ($request['status']) {
				$active  = false;
				$mensaje = "Cuenta de usuario desactivada";
			} else {
				$active  = true;
				$mensaje = "Cuenta de usuario activada correctamente";
			}
			Usuario::where('idUsuario', '=', $request['userId'])->update(['activo' => $active]);
			return response()->json([
				'success' => true,
				'message' => $mensaje,
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}
	public function randomPassword() {
		$alphabet    = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass        = array(); //remember to declare $pass as an array
		$count       = 0;
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 12; $i++) {
			if ($count === 4) {
				$pass[] = "-";
				$count  = 0;
			}
			$n      = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
			$count++;
		}
		return implode($pass); //turn the array into a string
	}
	public function SetTheme(Request $request) {
		try {
			$id                              = auth()->user()->idUsuario;
			$usuario                         = Usuario::select('settings')->where('idUsuario', '=', $id)->first();
			$theme                           = json_decode(json_encode($usuario), true);
			$theme['settings']['dark_theme'] = $request['dark_theme'];
			Usuario::where('idUsuario', '=', $id)->update(['settings' => json_encode($theme['settings'])]);
			return response()->json([
				'success' => true,
				'message' => "Color de tema actualizado",
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}

}
