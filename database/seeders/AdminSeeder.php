<?php

namespace Database\Seeders;

use App\Models\User as Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'name' => 'Super admin',
            'email' => 'super_admin@admin.com',
            'password' => 'super_admin@admin.com',
        ]);
        $admin->syncRoles('super_admin');
    }
}
