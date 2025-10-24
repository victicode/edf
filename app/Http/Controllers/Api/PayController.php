<?php

namespace App\Http\Controllers\Api;

use App\Models\Pay;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PayController extends Controller
{
    public function getPayById($id){
        $pay = Pay::with(['booking.comunArea', 'user'])->find($id);

        return $this->returnSuccess(200, $pay);
    }
    public function payBooking(Request $request, $id) {
        $validated = $this->validateFieldsFromInput($request->all());
        if (count($validated) > 0) return $this->returnFail(400, $validated[0]);
        
        $prefixPayId = ['s', 't', 'y', 'd'];
        $pay = Pay::create([
            "user_id"       => $request->user()->id,
            "booking_id"    => $id,
            "amount"        => $request->amount,
            "reference"     => $request->reference ?? "000000",
            "pay_id"        => $prefixPayId[$request->pay_method].$id.'-'.rand(1000,9999),
            "pay_date"      => $request->pay_date ? date("Y-m-d", strtotime($request->pay_date)) :date("Y-m-d"),
            "pay_method"    => $request->pay_method,
            "status"        => 1
        ]);
        // Storage::disk('public')
        // ->put('vaucher/'.$request->vaucher->getClientOriginalName(), file_get_contents($request->vaucher));
        $this->updateBooking($id);
        $this->uploadVaucher($pay, $request);
        return $this->returnSuccess(200, ["idPay"=> $pay->id]);
    }
    public function updateStatus(Request $request, $payId){
        $pay = Pay::find($payId);

        if(!$payId) return $this->returnFail(404, ['messageType'=>'negative', 'message' =>'Pago no encontrado']);
        try {
            $pay->update([
                "status" => $request->status,
            ]);
    
            $return =  $pay->booking_id 
            ? $this->bookingActionByStatus($pay->booking_id, $request->status)
            : '';

        } catch (Exception $th) {
            //throw $th;
            return $this->returnFail(500, ['messageType'=> 'negative', 'message' => 'Error al cambiar estado de pago']);
        }
        
        
        return $this->returnSuccess(200, $return);
    }
    private function bookingActionByStatus($booking, $status){
        if($status == 0){
            $this->cancelBooking($booking);
            return  ['messageType'=> 'negative', 'message' => 'Pago cancelado con exito'];
        }
        $this->approveBooking($booking);
        return  ['messageType'=> 'positive', 'message' => 'Pago aprobado con exito'];
    }

    private function cancelBooking($booking){
        $CANCEL_VALUE = 0; 
        $booking = Booking::find($booking);
        $booking->update([
            "status" => $CANCEL_VALUE 
        ]);
    } 
    private function approveBooking($booking){
        $APPROVE_VALUE = 3; 
        $booking = Booking::find($booking);
        $booking->update([
            "status" => $APPROVE_VALUE 
        ]);

    } 
    private function validateFieldsFromInput($inputs){
        
        $rules =  $inputs['pay_method'] !=3 
        ?[
            'amount'    => ['required', 'numeric'],
            'pay_date'  => ['required', 'date'],
            'reference' => ['required', 'regex:/^[0-9 &]+$/i'],
            'pay_method'=> ['required', 'numeric'],
            'vaucher'   => ['required', 'file'],

        ]
        :[
            'amount'    => ['required', 'numeric'],
            'pay_method'=> ['required', 'numeric'],
        ];

        $messages = [
            'amount.required'     => 'El monto es requerido',
            'amount.numeric'      => 'El monto no es valido',
            'pay_date.required'   => 'La fecha es requerida',
            'pay_date.date'       => 'La fecha no es valida',
            'reference.required'  => 'la referencia es requerida',
            'reference.regex'     => 'la referencia no es valida',
            'pay_method.required' => 'Metodo de pago es requerido',
            'pay_method.numeric'  => 'Metodo de pago no es valido',
            'vaucher.required'    => 'Vaucher es requerido',
            'vaucher.file'        => 'Vaucher no valido'

        ];

        $validator = Validator::make($inputs, $rules, $messages)->errors();

        return $validator->all() ;
    }
    private function uploadVaucher($pay, $vaucher){
        $path = ""; 

        if ($vaucher->file("vaucher")) {
            $path = "/public/images/vaucher/".rand(1000000, 9999999)."_". trim(str_replace(" ", "_", $pay->id )) .".". $vaucher->file("vaucher")->extension();
            $vaucher->file("vaucher")->move(public_path() . "/images/vaucher/", $path);
        }  
        $pay->vaucher = $path;
        $pay->save();
    }
    private function updateBooking($id){
        Booking::find($id)->update([
            "status" => 2
        ]);
    }
}
