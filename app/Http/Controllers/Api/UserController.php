<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use JwtAuth;

class UserController extends Controller
{
    //
    public function show()
    {
        return Auth::guard('api')->user();
    }

    public function update(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user->name = $request->name; // $request->input('name') //se actualiza con la infomraicón que viene con el $request-
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        //la información en caché se eliminará "ACTUALIZARÁ" par aque los datos se muestren actualizados al hacer una petición GET
        JwtAuth::clearCache($user);  
    }
}
