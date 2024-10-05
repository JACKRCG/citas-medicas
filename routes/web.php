<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// rutas de "Especialidad"

//rutas que devuelven vistas
Route::get('/specialties', 'SpecialtyController@index');
Route::get('/specialties/create', 'SpecialtyController@create'); // para ver el formulario de registro
Route::get('/specialties/{specialty}/edit', 'SpecialtyController@edit'); //para editar un registro

//Route::+Verbo HTTP+('/...', 'SpecialtyController@+nombre del método dentro del controlador "los nombres son usados por convención o buenas prácticas"+');
Route::post('/specialties', 'SpecialtyController@store'); // para enviar información del formulario
Route::put('/specialties/{specialty}', 'SpecialtyController@update'); //gestiona la edición de una ruta especializada 
Route::delete('/specialties/{specialty}', 'SpecialtyController@destroy'); //elimina una especialidad

// rutas de Doctores
//ya contiene las rutas para cada método, ya no es necesario crearlas porque ya las tiene definidas el siguiente comando
Route::resource('doctors', 'DoctorController');

// rutas de Pacientes