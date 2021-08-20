<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolSyncPermissionSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
        #ENCARGADO-COMERCIAL
		$role1        = Role::find('2');
		$permissions1 = ['empresa-list',
			'empresa-create',
			'empresa-update',
			'empresa-delete',
			'contacto-list',
			'contacto-create',
			'contacto-update',
			'contacto-delete',
			'evento-list',
			'evento-create',
			'evento-update',
			"evento-settings",
			'participacion-list',
			'participacion-create',
			'participacion-update',
			'participacion-delete',
			'layout-list',
			'layout-create',
			'layout-update',
			'layout-delete',
			'contrato-list',
			'contrato-create',
			'contrato-update',
			'contrato-delete',
			'credencial-list',
			'credencial-create',
			'credencial-update',
			'credencial-delete'];
		$role1->syncPermissions($permissions1);
        #AUXILIAR-COMERCIAL
		$role2        = Role::find('3');
		$permissions2 = [
			'empresa-list',
			'empresa-create',
			'empresa-update',
			'contacto-list',
			'contacto-create',
			'contacto-update',
			'evento-list',
			"evento-settings",
			'participacion-list',
			'participacion-create',
			'participacion-update',
			'participacion-delete',
			'layout-list',
			'contrato-list',
			'contrato-create',
			'credencial-list',
        ];
		$role2->syncPermissions($permissions2);
        #ENCARGADO-LOGISTICA
        $role3        = Role::find('4');
		$permissions3 = [
			'empresa-list',
			'contacto-list',
			'evento-list',
			'participacion-list',
			'participacion-create',
			'participacion-update',
			'participacion-delete',
			'layout-list',
			'contrato-list',
			'contrato-create',
			'credencial-list',
        ];
		$role3->syncPermissions($permissions3);
        #AUXILIAR-LOGISTICA
        $role4        = Role::find('5');
		$permissions4 = [
			'empresa-list',
			'contacto-list',
			'evento-list',
			'participacion-list',
			'layout-list',
			'contrato-list',
        ];
		$role4->syncPermissions($permissions4);
        #CONTABILIDAD
        $role5        = Role::find('6');
		$permissions5 = [
			'empresa-list',
			'empresa-create',
			'empresa-update',
			'contacto-list',
			'contacto-create',
			'contacto-update',
			'evento-list',
			"evento-settings",
			'participacion-list',
			'participacion-create',
			'participacion-update',
			'participacion-delete',
			'layout-list',
			'contrato-list',
			'contrato-create',
			'credencial-list',
        ];
		$role5->syncPermissions($permissions5);
        #SISTEMAS
        $role6 = Role::find(7);
        $permissions6 = Permission::pluck('id','id')->all();
        $role6->syncPermissions($permissions6);
         #CREDENCIALIZACION
         $role7        = Role::find('8');
         $permissions7 = [
             'empresa-list',
             'contacto-list',
             'evento-list',
             'participacion-list',
             'layout-list',
             'contrato-list',
             'credencial-list',
             'credencial-create',
             'credencial-update',
             'credencial-delete',
         ];
         $role7->syncPermissions($permissions7);
         #SECRETARIA
         $role8        = Role::find('9');
         $permissions8 = [
             'empresa-list',
             'contacto-list',
             'evento-list',
             'participacion-list',
             'layout-list',
             'contrato-list',
             'credencial-list',
         ];
         $role8->syncPermissions($permissions8);
         #SECRETARIA
         $role9        = Role::find('10');
         $permissions9 = [
             'empresa-list',
             'contacto-list',
             'evento-list',
             'participacion-list',
             'layout-list',
             'contrato-list',
             'credencial-list',
         ];
         $role9->syncPermissions($permissions9);
	}
}
