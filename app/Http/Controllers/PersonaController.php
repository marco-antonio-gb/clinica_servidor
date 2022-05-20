<?php
namespace App\Http\Controllers;
use App\Http\Requests\Persona\StorePersona;
use App\Http\Requests\Persona\UpdatePersona;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try {
			$resultado = Persona::all();
			if (!$resultado->isEmpty()) {
				return response()->json([
					'data'    => $resultado,
					'success' => true,
				], 200);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'No existen personas registradas',
				], 200);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function store(StorePersona $request) {
		try {
			DB::beginTransaction();
			$persona = [
				'nombres'      => $request['nombres'],
				'paterno'      => $request['paterno'],
				'materno'      => $request['materno'],
				'ci'           => $request['ci'],
				'ci_ext'       => $request['ci_ext'],
				'direccion'    => $request['direccion'],
				'celular'      => $request['celular'],
				'estado_civil' => $request['estado_civil'],
				'correo'       => $request['correo'],
				'fec_nac'      => $request['fec_nac'],
                'genero'      => $request['genero'],
				'foto'      => $request['foto'],
			];
			Persona::create($persona);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Persona registrada correctamente',
			], 201);
		} catch (\Exception $ex) {
			DB::rollback();
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		try {
			$persona = Persona::where('idPersona', '=', $id)->first();
			if ($persona) {
				return response()->json([
					'success' => true,
					'data'    => $persona,
				], 200);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'No se encontro ningun registro',
				]);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function update(UpdatePersona $request, $id) {
		try {
			DB::beginTransaction();
			$persona = [
				'nombres'      => $request['nombres'],
				'paterno'      => $request['paterno'],
				'materno'      => $request['materno'],
				'ci'           => $request['ci'],
				'ci_ext'       => $request['ci_ext'],
				'direccion'    => $request['direccion'],
				'celular'      => $request['celular'],
				'estado_civil' => $request['estado_civil'],
				'correo'       => $request['correo'],
				'fec_nac'      => $request['fec_nac'],
				'genero'      => $request['genero'],
				'foto'      => $request['foto'],
			];
			Persona::where('idPersona','=',$id)->update($persona);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Registrado actualizado correctamente',
			], 201);
		} catch (\Exception $ex) {
			DB::rollback();
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function destroy($id) {

		try {
			$persona = Persona::find($id);

			if (empty($persona)) {
				return response()->json([
					'success' => false,
					'message' => 'No se encontro el registro solicitado',
				], 404);
			}

			$deleted = $persona->delete($id);
			if (!$deleted) {
				return response()->json([
					'success' => false,
					'message' => 'No se pudo eliminar el registro',
				], 404);
			}
			return response()->json([
				'success' => true,
				'message' => 'Regsitro eliminado correctamente',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
}
