<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\ScheduleServiceInterface;

use App\WorkDay;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function hours(Request $request, ScheduleServiceInterface $scheduleService)
    {
        $rules = [
            'date' => 'required|date_format:"Y-m-d"',
            'doctor_id' => 'required|exists:users,id'
        ];
        $request->validate($rules);

        //dd($request->all());
        $date = $request->input('date');
        $doctorId = $request->input('doctor_id');
        //esta parte del codigo se mueve y se trabaja en ScheduleService 
        return $scheduleService->getAvailableIntervals($date, $doctorId);        
    }
    //esta parte del codigo se mueve y se trabaja en ScheduleService 
}
