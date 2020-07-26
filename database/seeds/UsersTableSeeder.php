<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Admin;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        DB::table('role_user')->truncate();

        // $admin = Admin::first();

        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $employeeRole = Role::where('name', 'employee')->first();

        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Hassan',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'owner' => false,
            ]);
            
        $manager = User::create([
            'created_by_admin_id' => $admin->id,
            'first_name' => 'Manager',
            'last_name' => 'Omer',
            'email' => 'manager@manager.com',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'owner' => false,
        ]);

        $employee = User::create([
            'created_by_manager_id' => $manager->id,
            'first_name' => 'Employee',
            'last_name' => 'Omer',
            'email' => 'employee@employee.com',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'owner' => false,
        ]);

        $admin->roles()->attach($adminRole);
        $manager->roles()->attach($managerRole);
        $employee->roles()->attach($employeeRole);
    }
}
