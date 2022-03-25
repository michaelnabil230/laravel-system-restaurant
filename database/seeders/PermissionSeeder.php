<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $models = config('permission.models_permissions');
        foreach ($models as $model => $permissions) {
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission . '_' . $model]);
            }
        }
    }
}
