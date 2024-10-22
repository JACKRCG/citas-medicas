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
        'address' => '',
        'phone' => '',
        'role' => 'admin'
        ]);
        
        //para generar los otros 50 registros
        factory(User::class, 50)->create();
    }
}
