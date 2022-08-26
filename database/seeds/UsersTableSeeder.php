<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'), 
            'dni' => '123344533',
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Estudiante',
            'email' => 'estudiante@gmail.com',
            'password' => bcrypt('123456'), 
            'dni' => '123344533',
            'role' => 'patient'
        ]);

        User::create([
            'name' => 'Tutor',
            'email' => 'tutor@gmail.com',
            'password' => bcrypt('123456'), 
            'dni' => '123344544',
            'role' => 'doctor'
        ]);
        factory(User::class, 50)->states('patient')->create();
    }
}
