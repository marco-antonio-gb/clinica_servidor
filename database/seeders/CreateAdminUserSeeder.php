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
        $role = Role::create(['name' => 'Administrador','descripcion'=>'Usuario con provilegios globales, acceso total al sistema.']);
        $permissions = Permission::pluck('id','id')->all();
        $user->givePermissionTo($permissions);
        // $role->syncPermissions($permissions);
        // $user->assignRole([$role->id]);
    }
}
