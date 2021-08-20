<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;



class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
     
        Role::create([
            'name'=>"Encargado-Comercial",
            'guard_name'=>"api",
            'descripcion'=>"Usuario que podra realizar tareas en el modulo de Reservas, Expositores, Empresas y Participaciones",
        ]);
        Role::create([
            'name'=>"Auxiliar-Comercial",
            'guard_name'=>"api",
            'descripcion'=>"Usuario que podra realizar tareas limitadas en el modulo de Reservas, Expositores, Empresas y Participaciones",
        ]);
        Role::create([
            'name'=>"Encargado-Logistica",
            'guard_name'=>"api",
            'descripcion'=>"Usuario que podra realizar tareas en el modulo de Reservas, Expositores, Empresas y Participaciones",
        ]);
        Role::create([
            'name'=>"Auxiliar-Logistica",
            'guard_name'=>"api",
            'descripcion'=>"Usuario que podra realizar tareas limitadas en el modulo de Reservas, Expositores, Empresas y Participaciones",
        ]);
        Role::create([
            'name'=>"Contabilidad",
            'guard_name'=>"api",
            'descripcion'=>"Usuario que podra ver la informacion de las reservas, clientes y empresas",
        ]);
        Role::create([
            'name'=>"Sistemas",
            'guard_name'=>"api",
            'descripcion'=>"Usuario con privilegios en los modulos de Reservas y su configuracion, Contratos, Expositores, Empresas y usuarios del sistema",
        ]);
        Role::create([
            'name'=>"Credencializacion",
            'guard_name'=>"api",
            'descripcion'=>"Usuario temporal habilitado unicamente para realizar tareas de credencializacion.",
        ]);
        Role::create([
            'name'=>"Secretaria",
            'guard_name'=>"api",
            'descripcion'=>"Usuario con acceso a los modulos: Expositores, Empresas y Participaciones",
        ]);
        Role::create([
            'name'=>"Invitado",
            'guard_name'=>"api",
            'descripcion'=>"Usuario con privilegios de solo lectura en los modulos definidos internamente por el Administrador o Encargado de Sistemas",
        ]);
    }
}
