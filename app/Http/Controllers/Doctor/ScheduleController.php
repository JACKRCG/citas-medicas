<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\WorkDay;

class ScheduleController extends Controller
{
    //
    public function edit()
    {
        $days = [
            'Lunes','Martes','Miercoles',
            'Jueves','Viernes','Sábado','Domingo'
        ];
        return view('schedule', compact('days'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        //si active no existe lo reemplazamos por un arreglo vacío, "?:" pregunta si la solicitud es null
        $active = $request->input('active') ?: [];
        $morning_start = $request->input('morning_start');
        $morning_end = $request->input('morning_end');
        $afternoon_start = $request->input('afternoon_start');
        $afternoon_end = $request->input('afternoon_end');

        //con el bucle for iremos pasando losvalores de los arreglos de las variables de arriba "$active,$mornin"... 
        //al método de abajo de updateOrCreate
        for($i=0; $i<7; ++$i)

            //losvalores day y user_id determinan la busqueda para poder determinar si se creará o actualizarán datos
            WorkDay::updateOrCreate(
                [
                    'day' => $i,
                    'user_id' => auth()->id()
                ],[   //active es probable que no exista// active contiene los dias que estan activos
                    //in_array nos ayuda a buscar un elemento dentro de un arregli de elementos
                    'active' => in_array($i, $active),

                    'morning_start' => $morning_start[$i],
                    'morning_end' => $morning_end[$i],

                    'afternoon_start' => $afternoon_start[$i],
                    'afternoon_end' => $afternoon_end[$i]
                ]
            );

        return back();
    }

}
