<?php

/*
|--------------------------------------------------------------------------
| Web Routes ------ Definición de rutas
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//indica el redireccionamiento o ubicación de la ruta inicial al cargar el sitio web
Route::get('/', function () {
    return redirect('/login'); //view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'admin'])->namespace('Admin')->group(function () {
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
    Route::resource('patients', 'PatientController');

    //Gráficos o Charts (Lineal)
    Route::get('/charts/appointments/line', 'ChartController@appointments');
    //Gráficos o Charts (Barras o Columnas)
    Route::get('/charts/doctors/column', 'ChartController@doctors');
    Route::get('/charts/doctors/column/data', 'ChartController@doctorsJson');
});


Route::middleware(['auth', 'doctor'])->namespace('Doctor')->group(function () {
    
    Route::get('/schedule', 'ScheduleController@edit');
    Route::post('/schedule', 'ScheduleController@store');
    
});

Route::middleware('auth')->group(function () {

    Route::get('/appointments/create', 'AppointmentController@create');
    Route::post('/appointments', 'AppointmentController@store');

    /*
    /patient/appointments
    */

    Route::get('/appointments', 'AppointmentController@index');
    Route::get('/appointments/{appointment}', 'AppointmentController@show');
    //para cancelar una cita despues de ser aprobada
    //Route::get('/appointments/{appointment}/cancel', 'AppointmentController@ShowCancelForm');//antes
    Route::get('/appointments/{appointment}/cancel', 'AppointmentController@showCancelForm');
    //para cancelar una cita antes de ser aprobada
    Route::post('/appointments/{appointment}/cancel', 'AppointmentController@postCancel');
    //para confirmar una cita
    Route::post('/appointments/{appointment}/confirm', 'AppointmentController@postConfirm');
    
    //JSON
    Route::get('/specialties/{specialty}/doctors', 'Api\SpecialtyController@doctors');
    Route::get('/schedule/hours', 'Api\ScheduleController@hours');

});


