<?php
namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller {
	/**
	 * Create a new AuthController instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth:api', ['except' => ['login']]);
	}
	/**
	 * Get a JWT via given credentials.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login() {
		$credentials = request(['email', 'password']);
		if (Usuario::where('email', '=', $credentials['email'])->exists()) {
			$verificarEstado = Usuario::select('estado')->where('email', '=', $credentials['email'])->get()->first();
			if ($verificarEstado['estado'] == 0) {
				return response()->json([
					'success'     => false,
					'error'       => 'Esta cuenta esta Desactivada',
					'status_code' => 401,
				], 401);
			} else {
				if (!$token = auth('api')->attempt($credentials)) {
					return response()->json([
						'success'     => false,
						'error'       => 'Los datos no son correctos',
						'status_code' => 401,
					], 401);
				}
				return $this->respondWithToken($token);
			}
		} else {
			return response()->json([
				'success'     => false,
				'error'       => 'La cuenta no existe',
				'status_code' => 401,
			], 401);
		}
	}
	/**
	 * Get the authenticated User.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function userProfile() {
		$id      = auth()->user()->idUsuario;
		$usuario = Usuario::where('idUsuario', '=', $id)->first();
        $usuario->setAttribute('roles',$this->getAllRoles($id));
        $usuario->setAttribute('permisos',$this->getAllPermissions($id));
		return response()->json([
			'success' => true,
			'data'    => $usuario,
		]);
	}
	protected function getAllPermissions($id) {
		try {
			$user = Usuario::find($id);
			if ($user) {
				$permisos = $user->getPermissionsViaRoles()->pluck('name');
				if ($permisos->isEmpty()) {
					return "No existen permisos para este usuario";
				} else {
					return $permisos;
				}
			} else {
				return 'No existen resultados';
			}
		} catch (\Exception $ex) {
			return $ex->getMessage();
		}
	}
	protected function getAllRoles($id) {
		try {
			$user = Usuario::find($id);
			if ($user) {
				$permisos = $user->roles->pluck('name');
				if ($permisos->isEmpty()) {
					return "No existen roles para este usuario";
				} else {
					return $permisos;
				}
			} else {
				return 'No existen resultados';
			}
		} catch (\Exception $ex) {
			return $ex->getMessage();
		}
	}
	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout() {
		auth()->logout();
		return response()->json(['message' => 'Successfully logged out']);
	}
	/**
	 * Refresh a token.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh() {
		return $this->respondWithToken(auth()->refresh());
	}
	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithToken($token) {
 
		return response()->json([
			'success' => true,
			'access_token' => $token,
			'user'=>auth()->user(),
			'expires_in' => auth()->factory()->getTTL() / 60,
			// 'status_code'=>200
		]);
	}
}
