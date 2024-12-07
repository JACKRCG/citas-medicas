<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Appointment;
use App\User;
use DB;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function appointments()
    {
        //created_At -> dateTime        
        $monthlyCounts = Appointment::select(
            DB::raw('MONTH(created_at) as month'), 
            DB::raw('COUNT(1) as count')
        )->groupBy('month')->get()->toArray();
        // [ ['month'=>11, 'count'=>3] ]
        // [0, 0, 0, 0, 0, ..., 3, 0]

        //$counts genera el arreglo con 12 ceros que representan las cantidades de citas en los 12 meses
        $counts = array_fill(0, 12, 0); //desde que valor empezar, cuantos valores necesitamos, que valor queremos usar
        foreach ($monthlyCounts as $monthlyCount) {
            $index = $monthlyCount['month']-1;
            $counts[$index] = $monthlyCount['count'];
        }

        return view('charts.appointments', compact('counts'));
    }

    public function doctors()
    {
        $now = Carbon::now();
        $end = $now->format('Y-m-d');
        $start = $now->subYear()->format('Y-m-d'); //inicio desde hace un año
        
        return view('charts.doctors', compact('start', 'end'));
    }

    public function doctorsJson(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        
        $doctors = User::doctors()
            ->select('name')
            ->withCount([
                'asDoctorAppointments' => function ($query) use ($start, $end) {
                    $query->whereBetween('scheduled_date', [$start, $end]);
                },
                'attendedAppointments' => function ($query) use ($start, $end) {
                    $query->whereBetween('scheduled_date', [$start, $end]);
                },
                'cancelledAppointments' => function ($query) use ($start, $end) {
                    $query->whereBetween('scheduled_date', [$start, $end]);
                }
            ])
            /*laravel traduce 'attended_appointments_count' como si quisieramos contar las citas atendidas*/
            ->orderBy('attended_appointments_count', 'desc')
            ->take(4)
            /*->get()->toArray();//con este último obtenemos un arreglo, 
            sin el toArray obtenemos Colleciones que son rpoporcionadas por php, 
            estos tienen mas métodos para poder controlar la informacióm.*/
            ->get();

        $data = [];
        $data['categories'] = $doctors->pluck('name');

        $series = [];

        
        $series0['name'] = 'Total de citas registradas';
        $series0['data'] = $doctors->pluck('as_doctor_appointments_count'); //Total de Citas

        $series1['name'] = 'Citas atendidas';
        $series1['data'] = $doctors->pluck('attended_appointments_count'); //Atendidas

        $series2['name'] = 'Citas canceladas';
        $series2['data'] = $doctors->pluck('cancelled_appointments_count'); //Canceladas

        $series[] = $series0;
        $series[] = $series1;
        $series[] = $series2;

        $data['series'] = $series;
        
        return $data;
    }

}
