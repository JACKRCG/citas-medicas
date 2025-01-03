<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Specialty;

use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //la funcion de doctors se enceuntra en "User.php"
        $doctors = User::doctors()->get();

        $role = auth()->user()->role;
        return view('doctors.index', compact('doctors', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //pasamos las especialidades a la vista doctor.create
        $specialties = Specialty::all();
        $role = auth()->user()->role;
        return view('doctors.create', compact('specialties', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        //validar la información
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'dni' => 'nullable|digits:8',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:6'
        ];
        $this->validate($request, $rules);
            //$request->all(); //esto trae todos los campos del formulario incluyendo los que se creen en el lado del cliente.
        $user = User::create(
            $request->only('name','email','dni','address','phone')
            + [
                'role' => 'doctor',
                'password' => bcrypt($request->input('password'))
            ]
        );

        $user->specialties()->attach($request->input('specialties'));

        $notification = 'El médico se ha registrado correctamente';
        return redirect('/doctors')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = User::doctors()->findOrFail($id);
        $specialties = Specialty::all();
        $specialty_ids = $doctor->specialties()->pluck('specialties.id');

        $role = auth()->user()->role;
        return view('doctors.edit', compact('doctor', 'specialties', 'specialty_ids', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //validar la información
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'dni' => 'nullable|digits:8',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:6'
        ];
        $this->validate($request, $rules);
            //$request->all(); //esto trae todos los campos del formulario incluyendo los que se creen en el lado del cliente.
        $user = User::doctors()->findOrFail($id);

        $data = $request->only('name', 'email', 'dni', 'address', 'phone');
        $password = $request->input('password');
        if ($password)
            $data ['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();//UPDATE -- para actualizar la información en la base de datos

        $user->specialties()->sync($request->input('specialties'));

        $notification = 'La información del médico se ha actualizado correctamente';
        return redirect('/doctors')->with(compact('notification'));
    }

    public function destroy(User $doctor)
    {
        $doctorName = $doctor->name;
        $doctor->delete();

        $notification = 'El médico '. $doctorName .' se ha eliminado correctamente';
        return redirect('/doctors')->with(compact('notification'));
    }
}
