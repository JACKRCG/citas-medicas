<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Workday;
//importamos desde su packete correspondiente
use Carbon\Carbon;

class ScheduleController extends Controller
{

    private $days = [
        'Lunes','Martes','Miercoles',
        'Jueves','Viernes','Sábado','Domingo'
    ];

    //
    public function edit()
    {
        //obtiene todos los datos del doctor que ha iniciado la sesion para poder ver su horario
        $workDays = Workday::where('user_id', auth()->id())->get();

        if (count($workDays) > 0) {
            $workDays->map(function ($workDay) {
            $workDay->morning_start = (new Carbon($workDay->morning_start))->format('g:i A');
            $workDay->morning_end = (new Carbon($workDay->morning_end))->format('g:i A');
            $workDay->afternoon_start = (new Carbon($workDay->afternoon_start))->format('g:i A');
            $workDay->afternoon_end = (new Carbon($workDay->afternoon_end))->format('g:i A');
            return $workDay;
        });
        } else {
            $workDays = collect();
            for ($i=0; $i<7; ++$i)
                $workDays->push(new Workday());
        }
        
        
        //dd($workDays->toArray());
        $days = $this->days;
        return view('schedule', compact('workDays','days'));
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
        //declarando la variable errors como arreglo vacío
        $errors = [];

        //con el bucle for iremos pasando losvalores de los arreglos de las variables de arriba "$active,$mornin"... 
        //al método de abajo de updateOrCreate
        for($i=0; $i<7; ++$i) {
            if ($morning_start[$i] > $morning_end[$i]) {
                $errors [] = 'Las horas de la mañana son inconsistentes para el día ' . $this->days[$i] . '.';
            }
            if ($afternoon_start[$i] > $afternoon_end[$i]) {
                $errors [] = 'Las horas de la tarde son inconsistentes para el día ' . $this->days[$i] . '.';
            }

            //losvalores day y user_id determinan la busqueda para poder determinar si se creará o actualizarán datos
            Workday::updateOrCreate([
                'day' => $i,
                'user_id' => auth()->id()
            ],[ //active es probable que no exista// active contiene los dias que estan activos
                //in_array nos ayuda a buscar un elemento dentro de un arregli de elementos
                'active' => in_array($i, $active),

                'morning_start' => $morning_start[$i],
                'morning_end' => $morning_end[$i],

                'afternoon_start' => $afternoon_start[$i],
                'afternoon_end' => $afternoon_end[$i]
            ]);
        }

        if (count($errors) > 0) {
            return back()->with(compact('errors'));
        } else {
            $notification = 'Los cambios se han guardado correctamente.';
            return back()->with(compact('notification'));
        }


            
    }

}
