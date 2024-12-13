<?php namespace App\Services;

use App\Workday;
use App\Interfaces\ScheduleServiceInterface;
use Carbon\Carbon;
use App\Appointment;

class ScheduleService implements ScheduleServiceInterface
{

	public function isAvailableInterval($date, $doctorId, Carbon $start) 
	{
		//se consulta si no existe una cita para esta hora con este médico
        $exists = Appointment::where('doctor_id', $doctorId)
        	->where('scheduled_date', $date)
        	->where('scheduled_time', $start->format('H:i:s'))
        	->exists();

        	return !$exists; //available if already none exists
	}

	public function getAvailableIntervals($date, $doctorId)
	{
		$workDay = Workday::where('active', true)
            ->where('day', $this->getDayFromDate($date))
            ->where('user_id', $doctorId)
            ->first([
                'morning_start', 'morning_end',
                'afternoon_start', 'afternoon_end'
            ]);

        if (!$workDay) {
            return [];
        }

        $morningIntervals = $this->getIntervals(
            $workDay->morning_start, $workDay->morning_end,
            $date, $doctorId
        );

        $afternoonIntervals = $this->getIntervals(
            $workDay->afternoon_start, $workDay->afternoon_end,
            $date, $doctorId
        );

        $data = [];
        $data['morning'] = $morningIntervals;
        $data['afternoon'] = $afternoonIntervals;

        return $data;
	}

	private function getDayFromDate($date)
	{
        $dateCarbon = new Carbon($date);
        //La librería de Carbon toma el 0 como el Domingo y el 6 como el Sabado, tenemos que solucionar transformadndo estos datos
        //segun DayOfWeek 0 es Lunes y 6 es Domingo
        $i = $dateCarbon->dayOfWeek;
        $day = ($i==0 ? 6 : $i-1);
        return $day;
	}	

	//funcion para generar rangos de media hora para las atenciones 
    private function getIntervals($start, $end, $date, $doctorId) {
        $start = new Carbon($start);
        $end = new Carbon($end);

        $intervals = [];
        while ($start < $end) {
            $interval = [];
            

            $interval['start'] = $start->format('g:i A');

            $available = $this->isAvailableInterval($date, $doctorId, $start);

            //se va agregando 30 minutos que representa el tiempo de atención
            $start->addMinutes(30);
            $interval['end'] = $start->format('g:i A');            

            if($available) {
            	$intervals [] = $interval;
            }        
            
        }
        return $intervals;
    }

}