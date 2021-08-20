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
            "paterno"=> "Garcia",
            "materno"=> "Coca",
            "nombres"=> "Ana Marianela",
            "ci"=> "5444217",
            "ci_ext"=> "OR",
            "cargo"=> "Administrador de sistemas",
            "celular"=> "68317456",
            'password' => bcrypt('admin'),
            "email"=> "ana@gmail.com",
            "direccion"=> "Direccion",
            "settings" =>'{"dark_theme":false}'
        ]);
    }
}
