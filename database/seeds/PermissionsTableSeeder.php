<?php

use Ancora\Entities\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         *  Define permissoes para rotas do admin
         *
         *  @var \Illuminate\Routing\Route $route
         */
        foreach (Route::getRoutes() as $route) {
            if ($route->getPrefix() == 'admin'
                AND $route->getName() != 'admin.'
                AND substr($route->getName(), -4) != 'data'
                AND substr($route->getName(), -5) != 'store'
                AND substr($route->getName(), -6) != 'update'
                AND DB::table('permissions')
                    ->select('name')
                    ->where('name', $route->getName())
                    ->get()->count() == 0
            ) {
                $id = DB::table('permissions')->insertGetId([
                    'name' => $route->getName(),
                ]);

                DB::table('permission_role')->insert([
                    'permission_id' => $id,
                    'role_id' => 1,
                ]);

                if($route->getName() == 'admin.users.edit') {
                    $permission = Permission::find($id);
                    $permission->closure = function ($user, $id) {
                        return $user->id == $id || $user->hasRole('administrator');
                    };

                    $permission->save();
                }

                if($route->getName() == 'admin.users.destroy') {
                    $permission = Permission::find($id);
                    $permission->closure = function ($user, $id) {
                        return $user->id != $id && $user->hasRole('administrator');
                    };

                    $permission->save();
                }
            }
        }
    }
}
