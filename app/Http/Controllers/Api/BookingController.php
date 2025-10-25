<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ComunArea;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    //
    public function storeBooking(Request $request) {
        $validated = $this->validateFieldsFromInput($request->all());
        if (count($validated) > 0) return $this->returnFail(400, $validated[0]);


        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'comun_area_id' => $request->comun_area,
            'booking_number' => $request->user()->id.'00'.rand(1000, 9999),
            'date' => date('Y-m-d',strtotime($request->date)),
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'amount' => $request->amount,
            'note' => $request->note,
            'status' => $request->amount > 0 ? 1 : 3,
            'is_exclusive'=> $request->exclusive
        ]);
        // Storage::disk('public')
        // ->put('vaucher/'.$request->vaucher->getClientOriginalName(), file_get_contents($request->vaucher));
        return $this->returnSuccess(200, ['toPay' => $booking->amount > 0, 'id' => $booking->id]);
    }

    public function getBookingsByUser(Request $request) {
        
        $bookings = Booking::with('comunArea', 'user', 'pay')->orderBy("created_at", "desc");
        if($request->user()->id != 1){
            $bookings->where('user_id', $request->user()->id);
        }
        return $this->returnSuccess(200, $bookings->get());
    }

    public function getBookingById($id) {
        $booking = Booking::with('comunArea', 'user', 'pay')->find($id);
        return $this->returnSuccess(200, $booking);
    }
    public function getBookingByAreaId(Request $request, $areaId){

        $bookings = Booking::with('pay', 'user')->where('comun_area_id',$areaId)->orderBy("created_at", "desc");
        return $this->returnSuccess(200, $bookings->get());
    }
    public function applyFilter($bookings, $filters){

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

    public function cancelBooking($id){

        $booking = Booking::find($id);
        if(!$booking) return $this->returnFail(400, "Reserva no encontrada");
        $booking->update([
            "status" => 0
        ]);

        return $this->returnSuccess(200, 'ok');
    }
    public function getAvaibleBookingByDay(Request $request, $idArea){
        date_default_timezone_set('America/Caracas');
        $area = ComunArea::find($idArea); // Find comun area
        $date = date('Y-m-d',strtotime($request->date)); // get formatDate
        $bookingInDay = Booking::where('comun_area_id', $idArea)->where('date', $date)->get(); 
        $availableFrom  = $this->setRangeAvailableBooking($date, $area);
        $availableTo    = range(intval(substr($area->timeFrom, 0, 2)), intval(substr($area->timeTo, 0, 2))); // set default available hours
        
        $notAvailable = $this->filterAvailableTimeBooking($bookingInDay, $area);
        $availableFrom = $this->formattedResult($availableFrom, $notAvailable["From"]);
        $availableTo = $this->formattedResult($availableTo, $notAvailable["To"]);

        return $this->returnSuccess(200, ['bookings' => $bookingInDay, 'availableFrom' => $availableFrom, 'availableTo' => $availableTo]);
    }
    public function getPendings(){
        $waitStatus = 2;
        $pendings = Booking::where('status', $waitStatus)->get();

        return $this->returnSuccess(200, $pendings);
    }
    private function validateFieldsFromInput($inputs){
        $rules =[
            'comun_area' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'time_from' => ['required', 'regex:/^[0-9 : &]+$/i'],
            'time_to' => ['required', 'regex:/^[0-9 : &]+$/i'],
            'amount' => ['required', 'numeric'],
        ];
        $messages = [
            'comun_area.required' => 'El area común es requerida',
            'comun_area.numeric' => 'El area común no es valido',
            'date.required' => 'La fecha es requerida',
            'date.date' => 'La fecha no es valida',
            'time_from.required' => 'El horario de inicio es requerido',
            'time_from.regex' => 'El horario de inicio no es valido',
            'time_to.required' => 'El horario de fin es requerido',
            'time_to.regex' => 'El horario de fin no es valido',
            'amount.required' => 'El monto es requerido',
            'amount.numeric' => 'El monto no es valido',
        ];

        $validator = Validator::make($inputs, $rules, $messages)->errors();

        return $validator->all() ;
    }
    private function setRangeAvailableBooking($date, $area){

        if($date == date('Y-m-d')){
            $hour = date('H'); // get formatDate
            return range(intval($hour+1), intval(substr($area->timeTo, 0, 2))); // set default available hours
        }
        return range(intval(substr($area->timeFrom, 0, 2)), intval(substr($area->timeTo, 0, 2)));
    }
    private function filterAvailableTimeBooking($bookingInDay, $area){
        if($area->type == 2){
            return $this->filterIsExclusiveArea($bookingInDay);
        }
        return $this->filterNoExclusiveArea($bookingInDay, $area);
    }
    private function filterIsExclusiveArea($bookingInDay){
        $notAvailableFrom = []; 
        $notAvailableTo = []; 
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
        return [
            "From" => $notAvailableFrom,
            "To" => $notAvailableTo,
        ];
    }
    private function filterNoExclusiveArea($booking, $area){
        $bookingInDay = $booking->groupBy(function($item,$key) {
            return substr($item->time_from, 0, 2);
        });

        $notAvailableFrom = []; 
        $notAvailableTo = []; 

        foreach ($bookingInDay as $booking) {
            if($area->capacity == count($booking)){

                array_push($notAvailableFrom, intval(substr($booking[0]->time_from, 0, 2))); //add init hour of booking
                array_push($notAvailableTo, intval(substr($booking[0]->time_to, 0, 2))); //add more hours of booking
                if($booking[0]->booking_hour > 1) {
                    for ($i=1; $i < $booking[0]->booking_hour; $i++) { 
                        array_push($notAvailableFrom, intval(substr($booking[0]->time_from, 0, 2)) + $i); //add more hours of booking
                        array_push($notAvailableTo, intval(substr($booking[0]->time_from, 0, 2)) + $i); //add more hours of booking
                    }
                }
            }
        }
        return [
            "From" => $notAvailableFrom,
            "To" => $notAvailableTo,
        ];
    
    }
    private function formattedResult($availableFrom, $notAvailable) {
        $format = array_diff($availableFrom, $notAvailable); // diff between available and not available
        return array_values($format); // format simple array
    }
}
