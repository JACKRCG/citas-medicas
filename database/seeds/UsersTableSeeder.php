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
        //se crea un registro específico
        User::create([
        'name' => 'Jack Carhuaz',
        'email' => 'jackcarhgon3@gmail.com',
        'password' => bcrypt('J4a!R1c?'),
        'dni' => '75505111',
        'address' => 'Santa Clara ATE',
        'phone' => '923912874',
        'role' => 'admin'
        ]);

        User::create([
        'name' => 'Paciente Test',
        'email' => 'patient@gmail.com',
        'password' => bcrypt('12345678'),
        'dni' => '75505188',
        'role' => 'patient'
        ]);

        User::create([
        'name' => 'Médico Test',
        'email' => 'doctor@gmail.com',
        'password' => bcrypt('12345678'),
        'dni' => '75505199',
        'role' => 'doctor'
        ]);
        
        //para generar los otros 50 registros
        factory(User::class, 50)->states('patient')->create();
    }
}
