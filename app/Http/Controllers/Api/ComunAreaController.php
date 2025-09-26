<?php

namespace App\Http\Controllers\Api;

use App\Models\ComunArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ComunAreaController extends Controller
{
    //
    public function paginationAreas(Request $request)
    {
        $departaments = ComunArea::paginate(15);
        return $this->returnSuccess(200, $departaments);

    }
    public function storeArea(Request $request){
        //
        $validated = $this->validateFieldsFromInput($request->all());
        if (count($validated) > 0) return $this->returnFail(400, $validated[0]);


        ComunArea::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'warranty_price' => $request->warrantyPrice,
            'description'  => $request->description,
            'max_time_reserve' => $request->maxTime,
            'timeFrom' => $request->timeFrom,
            'timeTo' => $request->timeTo,
            'rules' =>$request->rules,
        ]);

        return $this->returnSuccess(200, 'ok');

    }
    private function validateFieldsFromInput($inputs){
        $rules =[
            'name'          => ['required', 'regex:/^[a-z 0-9 A-Z-À-ÿ .\-]+$/i'],
            'capacity'      => ['required', 'numeric'],
            'price'         => ['required', 'numeric'],
            'warrantyPrice' => ['required', 'numeric'],
            'description'   => [ 'regex:/^[a-z 0-9 A-Z-À-ÿ .\-]+$/i'],
            'maxTime'       => ['required'],
            'timeFrom'      => ['required'],
            'timeTo'        => ['required'],
            'rules'         => ['required', 'regex:/^[a-z 0-9 A-Z-À-ÿ ., \- \r\n  &]+$/i'],
        ];
        $messages = [
            'name.required'          => 'Nombre del area es requerido.',
            'name.regex'             => 'Nombre no valido',
            'capacity.required'      => 'Capacidad es requerida',
            'capacity.numeric'       => 'Capacidad no valida',
            'price.required'         => 'Precio es requerida',
            'price.numeric'          => 'Precio no valida',
            'warrantyPrice.required' => 'Garantia es requerida',
            'warrantyPrice.numeric'  => 'Garantia no valida',
            'description.regex'      => 'Description no valida',    
            'maxTime.required'       => 'Maximo de tiempo de reserva es requerido',
            'timeFrom.required'      => 'Horario de apertura',
            'timeTo.required'        => 'Horario de cerre',

        ];


         $validator = Validator::make($inputs, $rules, $messages)->errors();

        return $validator->all() ;

    }
}
