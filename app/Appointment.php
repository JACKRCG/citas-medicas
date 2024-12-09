<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $fillable = [
        'description',
        'specialty_id',
        'doctor_id',
        'patient_id',
        'scheduled_date',
        'scheduled_time',
        'type'
    ];

    //este método nos permitira acceder a una especialidad desde un appointment
    //indicamos el tipo de relación
    // N $appointment->specialty 1
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    // N $appointment->doctor 1
    public function doctor()
    {
        return $this->belongsTo(User::class);
    }
    // N $appointment->patient 1
    //larabel busca al patient y doctor pode medio de los "id" declarados arriba 'doctor_id' y 'patient_id'
    public function patient()
    {
        return $this->belongsTo(User::class);
    }

    // Appointment 1 - 1/0 CancelledAppointment
    // $appointment->cancellation->justification
    public function cancellation()
    {
        return $this->hasOne(CancelledAppointment::class);
    }

    //accesor
    //$appointment->scheduled_time_12
    public function getScheduledTime12Attribute() {
        return (new Carbon($this->scheduled_time))
        ->format('g:i A');
    }

}