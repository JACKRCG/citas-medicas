<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'dni', 'address', 'phone', 'role'
    ];

    //variables que no queremos que se muestren en una respuesta
    protected $hidden = [
        'password', 'remember_token', 'pivot',
        'email_verified_at', 'created_at', 'updated_at'
    ];
    //en la versión final se quita:?
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ];

    public static function createPatient(array $data)
    {
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'patient'
        ]);
    }

    //para asociar a losusuarios con multiples especialidades
    //asi podremos saber que especialidades tiene un médico
    //$users->specialty
    public function specialties()
    {
        return $this->belongsToMany(Specialty::class)->withTimestamps();
    }

    //creando 2 scopes para simplificar las consultas a la base de datos en los controladores de "paciente" y "doctor"
    //para agregar otra consulta se agrega otro where ej: "->where()"
    public function scopePatients($query)
    {
        return $query->where('role', 'patient');
    }

    public function scopeDoctors($query)
    {
        return $query->where('role', 'doctor');
    }
    //para ver el total de citas como doctor
    public function asDoctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
    //para ver citas atendidas
    public function attendedAppointments()
    {
        return $this->asDoctorAppointments()->where('status', 'Atendida');
    }
    //para ver citas atendidas
    public function cancelledAppointments()
    {
        return $this->asDoctorAppointments()->where('status', 'Cancelada');
    }
    //para ver el total de citas como paciente
    public function asPatientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function sendFCM($message) 
    {
        if (!$this->device_token)
            return;

        return fcm()->to([
                $this->device_token
            ])->notification([
                'title' => config('app.name'),
                'body' => $message
            ])->send();
    }

}
