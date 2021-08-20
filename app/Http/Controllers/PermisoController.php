<?php
/*
 * Copyright (c) 2021.  modem.ff@gmail.com | Marco Antonio Gutierrez Beltran
 */

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;
use Validator;

class PermisoController extends Controller
{

    public function index()
    {
        try {
            $result = Permiso::all();
            if (!$result->isEmpty()) {
                return response()->json([
                    'data'        => $result,
                    'success'     => true,
                    'total'       => count($result),
                    'message'     => 'Lista de permisos',
                    'status_code' => 200,
                ]);
            } else {
                return [
                    'success'     => false,
                    'message'     => 'No existen resultados',
                    'status_code' => 201,
                ];
            }
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'        => 'required|unique:permissions',
                'guard_name'  => 'required',

                'descripcion' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success'     => false,
                    'validator'   => $validator->errors()->all(),
                    'status_code' => 400,
                ]);
            } else {
                Permiso::create(array_merge(
                    $validator->validated()
                ));
                return response()->json([
                    'success'     => true,
                    'message'     => 'Permiso registrado correctamente',
                    'status_code' => 201,
                ], 201);
            }
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ], 404);
        }
    }

    public function show($id)
    {
        try {
            $result = Permiso::find($id);
            if ($result) {
                return [
                    'success'     => true,
                    'data'        => $result,
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

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'        => 'required',
                'guard_name'  => 'required',
                'descripcion' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success'     => false,
                    'validator'   => $validator->errors()->all(),
                    'status_code' => 400,
                ]);
            } else {
                $res_rol = [
                    'name'        => $request['name'],
                    'guard_name'  => $request['guard_name'],
                    'descripcion' => $request['descripcion'],
                ];
                Permiso::where('id', '=', $id)->update($res_rol);
                return response()->json([
                    'success' => true,
                    'message' => 'Permiso Actualizado correctamente',
                ], 201);
            }
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            Permiso::where('id', '=', $id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Permiso eliminado correctamente',
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ], 404);
        }
    }
}
