<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Persona;

class PersonaSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Persona::create([
			"paterno"=> "Garcia",
            "materno"=> "Coca",
            "nombres"=> "Ana Marianela",
            "ci"=> "5444217",
            "ci_ext"=> "OR",
            "fec_nac"=> "1990-02-14",
            "celular"=> "68317456",
            "correo"=> "ana@gmail.com",
            "direccion"=> "Direccion",
            "estado_civil" =>"Soltera",
            "genero" => "Femenino",

		]);
	}
}
