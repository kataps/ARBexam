<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->truncate();
        $adminRole = Role::create([
            'name' => 'Administrator',
            'description' =>  'super user',
        ]);
        $userRole = Role::create([
            'name' => 'User',
            'description'=> 'can add expenses'
        ]);
    }
}
