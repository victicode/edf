<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function store(Request $request) {

        $validated = $this->validateFieldsFromInput($request->all());

        if (count($validated) > 0) return $this->returnFail(400, $validated[0]);

        
       $user = User::create([
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'username'  =>  $request->username,
            'phone'     =>  $request->phone,
            'password'  =>  bcrypt($request->password) ,
            'rol_id'    =>  2,
        ]);

        if($request->idApartament != 0){
            Departament::find($request->idApartament)->update([
                'user_id' => $user->id
            ]);
        }

        return $this->returnSuccess(200, 'ok');

    }

    public function getOwners(Request $request) {

        $owners = User::with(['apartaments'])->where('rol_id', $request->rol)->orderBy('name', 'asc')->where('id', '!=', $request->user()->id)->get();

        return $this->returnSuccess(200, $owners);
    }

    private function validateFieldsFromInput($inputs){
        $rules =[
            'name'      => ['required', 'regex:/^[a-zA-Z-À-ÿ .]+$/i'],
            'email'     => ['required', 'email'],
            'username'  => ['required', 'regex:/^[a-zA-Z-À-ÿ0-9 .]+$/i'],
            'password'  => ['required', 'min:8'],

        ];
        $messages = [
            'name.required'     => 'El nombre es requerido.',
            'name.regex'        => 'Nombre no valido',
            'email.required'    => 'El email es requerido.',
            'email.email'       => 'Email no valido',
            'username.required' => 'Nombre de usuario es requerido',
            'username.regex'    => 'Nombre de usuario no valido',
            'password.required'     => 'La contraseña es requerida',
            'password.min'          => 'La contraseña debe tener un minimo de 8 caracteres'
        ];


         $validator = Validator::make($inputs, $rules, $messages)->errors();

        return $validator->all() ;

    }
}
