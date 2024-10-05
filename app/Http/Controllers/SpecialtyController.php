<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//creando una nueva directiva
use App\Specialty;

class SpecialtyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $specialties = Specialty::all();
        return view('specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('specialties.create');
    }
    //función para validar tanto en post y en put
    private function performValidation(Request $request)
    {
        //validaciones del lado del servidor
        $rules = [
            'name' => 'required|min:3'
        ];
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre.',
            'name.min' => 'Como mínimo el nombre debe tener 3 caracteres'
        ];

        $this->validate($request, $rules, $messages);
        //fin de validaciones
    }

    public function store(Request $request)
    {
        //dd($request->all());  //para ver los datos en formato de envio,... en pantalla
        // ejecución de la función de validaciones del lado del servidor
        $this->performValidation($request);
        
        //para agregar dentro de la base de datos una
        $specialty = new specialty();
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save(); //INSERT

        $notification = 'La especialidad se ha registrado correctamente.';
        return redirect('/specialties')->with(compact('notification'));
    }
    //para devolver una vista
    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty)
    {
        //dd($request->all());  //para ver los datos en formato de envio,... en pantalla
        // ejecución de la función de validaciones del lado del servidor
        $this->performValidation($request);
        //fin de validaciones
        
        //para agregar dentro de la base de datos una
        //esta es una especialidad ya existente
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save(); //UPDATE

        $notification = 'La especialidad se ha actualizado correctamente.';
        return redirect('/specialties')->with(compact('notification'));
    }

    public function destroy(Specialty $specialty)
    {   
        //antes de borrar la información, salvamos el nombre de la especialidad y la guardamos en una variable
        $deletedSpecialty = $specialty->name;
        //ejecutamos la funcion de borrar
        $specialty->delete();

        //mostramos el nombre de la especialidad con la variable que tiene el nombre 'salvado' mas el mensaje
        //para concatenar una variable se usan puntos ". ."
        $notification = 'La especialidad '. $deletedSpecialty .' se ha eliminado correctamente.';
        //redirige a la página principal de especialidades y envía a la página la variable de notificación
        return redirect('/specialties')->with(compact('notification'));
    }

}
