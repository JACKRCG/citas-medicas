<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\User;

use App\Http\Controllers\Controller;

class DocPatientController extends Controller
{
    public function index()
    {
        //la funcion de patients se enceuntra en "User.php"
        //para paginar en el frontend usamos "paginate(valor de filas a mostrar en la tabla)"
        $patients = User::patients()->orderByDesc('created_at')->paginate(10);
        //$patients = User::patients()->paginate(10);

        $role = auth()->user()->role;
        return view('doctors.patients.index', compact('patients', 'role'));
    }
}
