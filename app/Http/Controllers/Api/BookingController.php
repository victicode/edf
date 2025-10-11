<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ComunArea;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    //
    public function store(Request $request) {
        $validated = $this->validateFieldsFromInput($request->all());
        if (count($validated) > 0) return $this->returnFail(400, $validated[0]);

        Booking::create([
            'user_id' => $request->user()->id,
            'comun_area_id' => $request->comun_area_id,
            'date' => $request->date,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'amount' => $request->amount,
            'vaucher' => $request->vaucher,
            'reference' => $request->reference,
            'note' => $request->note,
            'pay_method' => $request->pay_method,
        ]);
        Storage::disk('public')
        ->put('vaucher/'.$request->vaucher->getClientOriginalName(), file_get_contents($request->vaucher));
        return $this->returnSuccess(200, 'ok');
    }

    public function getBookingsByUser(Request $request) {
        
        $bookings = Booking::with('comunArea', 'user');
        if($request->user()->id != 1){
            $bookings->where('user_id', $request->user()->id);
        }
        return $this->returnSuccess(200, $bookings->get());
    }
    public function getBookingById($id) {
        $booking = Booking::with('comunArea', 'user')->find($id);
        return $this->returnSuccess(200, $booking);
    }
    public function updateBooking(Request $request, $id) {
        $validated = $this->validateFieldsFromInput($request->all());
        if (count($validated) > 0) return $this->returnFail(400, $validated[0]);

        $booking = Booking::find($id);
        if(!$booking) return $this->returnFail(400, 'Reserva no encontrada');
        $booking->update($request->all());
        return $this->returnSuccess(200, 'ok');
    }
    public function deleteBooking($id) {
        $booking = Booking::find($id);
        if(!$booking) return $this->returnFail(400, 'Reserva no encontrada');
        $booking->delete();
        return $this->returnSuccess(200, 'ok');
    }
    public function getAvaibleBookingByDay(Request $request, $idArea){
        date_default_timezone_set('America/Caracas');
        $area = ComunArea::find($idArea); // Find comun area
        $date = date('Y-m-d',strtotime($request->date)); // get formatDate
        $bookingInDay = Booking::where('comun_area_id', $idArea)->where('date', $date)->get(); 
        $availableFrom  = range(intval(substr($area->timeFrom, 0, 2)), intval(substr($area->timeTo, 0, 2))); // set default available hours
        $availableTo    = range(intval(substr($area->timeFrom, 0, 2)), intval(substr($area->timeTo, 0, 2))); // set default available hours
        $notAvailableFrom = []; 
        $notAvailableTo = []; 
        // if()
        if($date == date('Y-m-d')){
            $hour = date('H'); // get formatDate
            $availableFrom  = range(intval($hour), intval(substr($area->timeTo, 0, 2))); // set default available hours
        }


        foreach ($bookingInDay as $booking) {
            array_push($notAvailableFrom, intval(substr($booking->time_from, 0, 2))); //add init hour of booking

            array_push($notAvailableTo, intval(substr($booking->time_to, 0, 2))); //add more hours of booking

            if($booking->booking_hour > 1) {
                for ($i=1; $i < $booking->booking_hour; $i++) { 
                    array_push($notAvailableFrom, intval(substr($booking->time_from, 0, 2)) + $i); //add more hours of booking
                    array_push($notAvailableTo, intval(substr($booking->time_from, 0, 2)) + $i); //add more hours of booking

                }
            }
        }

        $result = array_diff($availableFrom, $notAvailableFrom); // diff between available and not available
        $availableFrom = array_values($result); // format simple array

        $result = array_diff($availableTo, $notAvailableTo); // diff between available and not available
        $availableTo = array_values($result); // format simple array
        return $this->returnSuccess(200, [ 'bookings' => $bookingInDay, 'availableFrom' => $availableFrom, 'availableTo' => $availableTo,]);
    }
    private function validateFieldsFromInput($inputs){
        $rules =[
            'comun_area_id' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'time_from' => ['required', 'time'],
            'time_to' => ['required', 'time'],
            'amount' => ['required', 'numeric'],
            'vaucher' => ['required', 'file'],
            'reference' => ['regex:/^[0-9]+$/i'],
            'note' => ['regex:/^[a-z 0-9 A-Z-À-ÿ ., \- \r \n  &]+$/i'],
            'pay_method' => ['required', 'numeric'],
        ];
        $messages = [
            'comun_area_id.required' => 'El area común es requerida',
            'comun_area_id.numeric' => 'El area común no es valido',
            'date.required' => 'La fecha es requerida',
            'date.date' => 'La fecha no es valida',
            'time_from.required' => 'El horario de inicio es requerido',
            'time_from.time' => 'El horario de inicio no es valido',
            'time_to.required' => 'El horario de fin es requerido',
            'time_to.time' => 'El horario de fin no es valido',
            'amount.required' => 'El monto es requerido',
            'amount.numeric' => 'El monto no es valido',
            'vaucher.required' => 'El vaucher es requerido',
            'vaucher.file' => 'El vaucher no es valido',
            'reference.required' => 'La referencia es requerida',
            'reference.regex' => 'La referencia no es valida',
            'note.required' => 'La nota es requerida',
            'note.regex' => 'La nota no es valida',
            'pay_method.required' => 'El metodo de pago es requerido',
            'pay_method.numeric' => 'El metodo de pago no es valido',
        ];

        $validator = Validator::make($inputs, $rules, $messages)->errors();

        return $validator->all() ;
    }
}
