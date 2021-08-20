<?php
/*
 * Copyright (c) 2021.  modem.ff@gmail.com | Marco Antonio Gutierrez Beltran
 */
namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'usuario-list',
            'usuario-create',
            'usuario-update',
            'usuario-delete',
            'usuario-lock',
            #--------------
            'empresa-list',
            'empresa-create',
            'empresa-update',
            'empresa-delete',
            #--------------
            'contacto-list',
            'contacto-create',
            'contacto-update',
            'contacto-delete',
            #--------------
            'evento-list',
            'evento-create',
            'evento-update',
            'evento-delete',
            "evento-settings",
            #--------------
            'participacion-list',
            'participacion-create',
            'participacion-update',
            'participacion-delete',
            #--------------
            'layout-list',
            'layout-create',
            'layout-update',
            'layout-delete',
            #--------------
            'contrato-list',
            'contrato-create',
            'contrato-update',
            'contrato-delete',
            #--------------
            'credencial-list',
            'credencial-create',
            'credencial-update',
            'credencial-delete',
            #--------------
            'rol-list',
            'rol-create',
            'rol-update',
            'rol-delete',
            #--------------
            'permiso-list',
            'permiso-create',
            'permiso-update',
            'permiso-delete',
            #--------------
            'asignar-rol',
            'asignar-permiso',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


    }
}
