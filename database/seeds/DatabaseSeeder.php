<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $models = config('config_me.models');
        $maps = config('config_me.maps');
        foreach ($models as $index => $model) {
            foreach ($maps as $map) {
                Permission::create(['name' => $map . '_' . $model]);
            }
        }

        Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'super_admin']);
        $role->givePermissionTo(Permission::all());

        $user = \App\User::create([
            'name' => 'Super admin',
            'email' => 'super_admin@admin.com',
            'password' => bcrypt('super_admin@admin.com'),
        ]);
        $user->syncRoles('super_admin');

        \App\Setting::create([
            'name' => 'System Restaurant',
            'logo' => 'public/logo/default.png',
            'value_added' => 15.00,
        ]);
    }
}
