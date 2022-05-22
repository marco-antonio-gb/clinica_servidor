<?php
namespace Database\Seeders;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Usuario::find(1);
        $role = Role::find(1);
        $permissions = Permission::pluck('id','id')->all();
        $user->givePermissionTo($permissions);
        // $role->syncPermissions($permissions);
        $user->assignRole(1);
        
        
        $user2 = Usuario::find(2);
        // $role = Role::create(['name' => 'Administrador','descripcion'=>'Usuario con provilegios globales, acceso total al sistema.']);
        $permissions2 = ['medico-create',
        'medico-list',
        'medico-update',
        'medico-delete'];
        $user2->givePermissionTo($permissions2);
        // $role->syncPermissions($permissions);
        $user2->assignRole(2);


        
    }
}
