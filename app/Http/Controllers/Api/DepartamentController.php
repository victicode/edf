<?php

namespace App\Http\Controllers\Api;

use App\Models\Departament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class DepartamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function paginationApartment(Request $request)
    {
        $departaments = Departament::with('owner')->paginate(15);
        return $this->returnSuccess(200, $departaments);

    }

    /**
     * Display a listing of the resource.
     */
    public function apartmentsByfind(Request $request)
    {   
        $departaments = [];
        if($request->find == 'available'){

            $departaments = Departament::where('user_id', null)->get();
        }
        return $this->returnSuccess(200, $departaments);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeApartment(Request $request)
    {
        //
        $validated = $this->validateFieldsFromInput($request->all());
        if (count($validated) > 0) return $this->returnFail(400, $validated[0]);


        Departament::create([
            'number' => $request->number,
            'address' => $request->address,
            'block' => $request->block,
            'area' => $request->area,
            'description' => $request->description,
            'floor' => $request->floor
        ]);

        return $this->returnSuccess(200, 'ok');


    }

    /**
     * Display the specified resource.
     */
    public function show(Departament $departament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departament $departament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departament $departament)
    {
        //
    }

    private function validateFieldsFromInput($inputs){
        $rules =[
            'number'     => ['required', 'regex:/^[a-z 0-9 A-Z-À-ÿ .\-]+$/i'],
            'address'    => ['required', 'regex:/^[a-z 0-9 A-Z-À-ÿ ., &]+$/i'],
            'block'      => ['regex:/^[a-z 0-9 A-Z À-ÿ .]+$/i'],
            'area'       => ['required', 'numeric'],
            'floor'      => ['required', 'numeric'],
            'description' =>  ['regex:/^[a-z a-z 0-9 A-Z-À-ÿ ., \-]+$/i'],

        ];
        $messages = [
            'number.required'   => 'El número de apartamento es requerido.',
            'number.regex'      => 'número de apartamento no valido',
            'address.required'  => 'Dirección es requerida.',
            'address.regex'     => 'Dirección no valida',
            'block.regex'       => 'Número de bloque no valido',
            'area.required'     => 'Area es requerida',
            'area.numeric'      => 'Area no valida',
            'floor.required'    => 'Número de piso es requerida',
            'floor.numeric'     => 'Número de piso no valido',
            'description.regex' => 'Nota no valida',
            
        ];


         $validator = Validator::make($inputs, $rules, $messages)->errors();

        return $validator->all() ;

    }

}
