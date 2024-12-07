<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    //para asociar a las especialidades con multiples usuarios
    //de esta manera podremos acceder a la lista de médicos que están asociados con una especialidad
    //$specialty->users
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
