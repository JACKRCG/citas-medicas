<?php

use Illuminate\Database\Seeder;
use App\Specialty;
use App\User;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            'Oftalmología',
            'Pediatría',
            'Neurología'
        ];
//make me permite guardar datos en memoria y ni en la base de datos directamente
        foreach ($specialties as $specialtyName) {
            $specialty = Specialty::create([
                'name' => $specialtyName
            ]);    
            //saveMany espera una coleccion a diferencia de save() que solo espera un modelo
            $specialty->users()->saveMany(                
                factory(User::class, 3)->states('doctor')->make()
            );
        }    
        //medico test
        User::find(3)->specialties()->save($specialty);
    }
}
