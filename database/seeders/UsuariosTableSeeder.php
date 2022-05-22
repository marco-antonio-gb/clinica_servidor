<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder {

	public function run() {
		Usuario::create([
			"email"         => "ana@gmail.com",
			"password"      => bcrypt('ana@gmail.com'),
			"tipo_usuario"  => "Administrador",
			"fecha_ingreso" => "2022-04-15",
			"fecha_baja"    => NULL,
			"liquidacion"   => 0,
			"profesion"     => "Ingeniero de Sistemas",
			"referencia"    => "Ninguna",
			"estado"        => true,
			"persona_id"    => 1,
			"settings"      => '{"dark_theme": false,"avatarColor": "#3F51B5","avatarLetter": "A","userName": "Ana Marianela"}',
		]);

		Usuario::create([
			"email"         => "modem.ff@gmail.com",
			"password"      => bcrypt('modem.ff@gmail.com'),
			"tipo_usuario"  => "Medico",
			"fecha_ingreso" => "2022-04-15",
			"fecha_baja"    => NULL,
			"liquidacion"   => 0,
			"profesion"     => "Ingeniero de Sistemas",
			"referencia"    => "Ninguna",
			"estado"        => true,
			"persona_id"    => 2,
			"settings"      => '{"dark_theme": false,"avatarColor": "#3F51B5","avatarLetter": "M","userName": "Marco Antonio"}',
		]);
	}
}
