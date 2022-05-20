<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosTableSeeder extends Seeder
{
     
    public function run()
    {
        Usuario::create([
        "email" => "ana@gmail.com",
        "password" => bcrypt('admin'),
        "tipo_usuario" => "Administrador",
        "fecha_ingreso" => "2022-04-15",
        "fecha_baja" => NULL,
        "liquidacion" => 0,
        "profesion" => "Ingeniero de Sistemas",
        "referencia" => "Ninguna",
        "estado" =>true,
        "persona_id" => 1,

        ]);
    }
}
