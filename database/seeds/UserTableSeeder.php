<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //creating admin account
       $admin  = User::create([
           'name'=>'Alvin Katapusan',
           'username'=>'kataps',
           'password' => Hash::make('password'),
           'email' => 'admin@exam.com',
       ]);
       $adminRole = Role::where('name','Administrator')->first();
       $admin->roles()->attach($adminRole);
        //creating User account
       $user  = User::create([
        'name'=>'juan Cruz',
        'username'=>'juan',
        'password' => Hash::make('password'),
        'email' => 'juan@exam.com',
       ]);
        $userRole = Role::where('name','User')->first();
        $user->roles()->attach($userRole);

    }
}
