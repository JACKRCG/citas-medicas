<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;

use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //la funcion de patients se enceuntra en "User.php"
        //para paginar en el frontend usamos "paginate(valor de filas a mostrar en la tabla)"
        $patients = User::patients()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        User::create(
            $request->only('name','email','dni','address','phone')
            + [
                'role' => 'patient',
                'password' => bcrypt($request->input('password'))
            ]
        );

        $notification = 'El paciente se ha registrado correctamente';
        return redirect('/patients')->with(compact('notification'));
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

    public function edit(User $patient)
    {
        return view('patients.edit', compact('patient'));
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
        $user = User::patients()->findOrFail($id);

        $data = $request->only('name', 'email', 'dni', 'address', 'phone');
        $password = $request->input('password');
        if ($password)
            $data ['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();//UPDATE -- para actualizar la información en la base de datos

        $notification = 'La información del paciente se ha actualizado correctamente';
        return redirect('/patients')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $patient)
    {
        $patientName = $patient->name;
        $patient->delete();

        $notification = 'El paciente '. $patientName .' se ha eliminado correctamente';
        return redirect('/patients')->with(compact('notification'));
    }
}
