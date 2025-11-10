<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Pay;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Quota;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Notifications\RealtimeNotification;

class PayController extends Controller
{
    public function getPayById($id)
    {
        $pay = Pay::with(['booking.comunArea', 'user', 'quota'])->find($id);

        return $this->returnSuccess(200, $pay);
    }

    public function getPayQuotas($id)
    {
        $pay = Pay::with(['booking.comunArea', 'user'])->find($id);

        return $this->returnSuccess(200, $pay);
    }

    public function getPaysByUser(Request $request)
    {
        $pays = Pay::with(['booking.comunArea', 'quota', 'user']);

        // Filtrar por usuario si no es admin
        if ($request->user()->id != 1) {
            $pays->where('user_id', $request->user()->id);
        }

        // Aplicar filtros
        $this->applyPaysFilter($pays, $request);

        return $this->returnSuccess(200, $pays->get());
    }

    private function applyPaysFilter($query, Request $request)
    {
        $VIEW_ALL_STATUS = 4;

        // Filtro por estado
        if ($request->filled('status') && intval($request->status) !== $VIEW_ALL_STATUS) {
            $query->where('status', intval($request->status));
        }

        // Filtro por método de pago
        if ($request->filled('pay_method')) {
            $query->where('pay_method', intval($request->pay_method));
        }

        // Filtro por tipo de pago
        if ($request->filled('type')) {
            $query->where('type', intval($request->type));
        }

        // Filtro por rango de fechas
        if ($request->filled('date_from')) {
            $query->whereDate('pay_date', '>=', $request->get('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('pay_date', '<=', $request->get('date_to'));
        }

        // Ordenamiento
        $validSortFields = ['created_at', 'pay_date', 'amount', 'status'];
        $sortBy = in_array($request->get('sort_by'), $validSortFields)
            ? $request->get('sort_by') : 'created_at';
        $sortDir = $request->get('sort_dir') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortDir);
    }
    public function storePay(Request $request)
    {
        $validated = $this->validateFieldsFromInput($request->all());
        if (count($validated) > 0) {
            return $this->returnFail(400, $validated[0]);
        }

        $prefixPayId = ['s', 't', 'y', 'd'];

        $pay = Pay::create([
            "user_id"       => $request->user()->id,
            "booking_id"    => $request->type == 2 ? $request->to_pay_id : null,
            "quota_id"      => $request->type == 1 ? $request->to_pay_id : null,
            "amount"        => $request->amount,
            "reference"     => $request->reference ?? "000000",
            "pay_id"        => $prefixPayId[$request->pay_method] . ($request->booking_id ?? $request->quota_id) . '-' . rand(1000, 9999),
            "pay_date"      => $request->pay_date ? date("Y-m-d", strtotime($request->pay_date)) : date("Y-m-d"),
            "type"          => $request->type,
            "pay_method"    => $request->pay_method,
            "status"        => 1
        ]);

        $this->afterPayAction($pay);
        $this->uploadVaucher($pay, $request);
        $this->sendNotification($pay);
        return $this->returnSuccess(200, ["idPay" => $pay->id]);
    }
    public function updateStatus(Request $request, $payId)
    {
        $pay = Pay::with(["booking"])->find($payId);

        if (!$payId) {
            return $this->returnFail(404, ['messageType' => 'negative', 'message' => 'Pago no encontrado']);
        }

        try {
            $pay->update([
                "status" => $request->status,
            ]);

            $return =  $pay->booking_id
            ? $this->bookingActionByStatus($pay)
            : '';
        } catch (Exception $th) {
            return $this->returnFail(500, ['messageType' => 'negative', 'message' => 'Error al cambiar estado de pago']);
        }

        return $this->returnSuccess(200, $return);
    }
    private function afterPayAction($pay)
    {
        if ($pay->type == 2) {
            $this->updateBooking($pay->booking_id);
            return;
        }
        $this->updateQuota($pay->quota_id);
    }
    private function bookingActionByStatus($pay)
    {
        $returnMessage = $pay->status == 0
        ? ['messageType' => 'negative', 'message' => 'Pago cancelado con exito']
        : ['messageType' => 'positive', 'message' => 'Pago aprobado con exito'];

        $pay->status == 0
        ? $this->cancelBooking($pay->booking_id)
        : $this->approveBooking($pay->booking_id);

        $this->sendReserveNotification($pay);
        return $returnMessage;
    }
    private function cancelBooking($booking)
    {
        $CANCEL_VALUE = 0;
        $booking = Booking::find($booking);
        $booking->update([
            "status" => $CANCEL_VALUE
        ]);
    }
    private function approveBooking($booking)
    {
        $APPROVE_VALUE = 3;
        $booking = Booking::find($booking);
        $booking->update([
            "status" => $APPROVE_VALUE
        ]);
    }
    private function validateFieldsFromInput($inputs)
    {

        $rules =  $inputs['pay_method'] != 3
        ? [
            'amount'     => ['required', 'numeric'],
            'pay_date'   => ['required', 'date'],
            'reference'  => ['required', 'regex:/^[0-9 &]+$/i'],
            'pay_method' => ['required', 'numeric'],
            'vaucher'    => ['required', 'file'],

        ]
        : [
            'amount'     => ['required', 'numeric'],
            'pay_method' => ['required', 'numeric'],
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
    private function uploadVaucher($pay, $vaucher)
    {
        $path = "";

        if ($vaucher->file("vaucher")) {
            $rand = rand(1000000, 9999999);
            $fileName = trim(str_replace(" ", "_", $pay->id));
            $extension = $vaucher->file("vaucher")->extension();
            $path = "/public/images/vaucher/{$rand}_{$fileName}.{$extension}";
            $vaucherPath = public_path() . "/images/vaucher/";
            $vaucher->file("vaucher")->move($vaucherPath, $path);
        }
        $pay->vaucher = $path;
        $pay->save();
    }
    private function updateBooking($id)
    {
        Booking::find($id)->update([
            "status" => 2
        ]);
    }

    private function updateQuota($id)
    {
        Quota::find($id)->update([
            "status" => 2
        ]);
    }

    private function sendNotification($pay)
    {
        $users = [
            "admin" => User::find(1),
            "client" => User::find($pay->user_id),
        ];
        $dataNotificaction = $this->getDataToNotification($pay);

        try {
            $users["client"]->notify(new RealtimeNotification(
                title: $dataNotificaction["title"],
                message: $dataNotificaction["message"],
                url: $dataNotificaction["url"],
                meta: $dataNotificaction["meta"],
            ));
        } catch (\Throwable $e) {
            // Silenciar errores de notificación para no romper el flujo
        }
    }

    private function getDataToNotification($pay)
    {
        return $pay->type == 1
        ? [
            "title" => "Pago realizado",
            "message" => "Tu pago por la cuota #" . $pay->quota->number
                . "fue realizado, el personal de administración lo validará en breve.",
            "url" => "/client/reserves/view/" . $pay->id,
            "meta" =>  ['booking_id' => $pay->id],
        ]
        : [
            "title" => "Pago de reserva realizado",
            "message" => "Tu pago por la reserva #" . $pay->booking->booking_number
                . "fue realizado, el personal de administración lo validará en breve.",
            "url" => "/client/reserves/view/" . $pay->id,
            "meta" =>  ['booking_id' => $pay->id],
        ];
    }
    private function sendReserveNotification($pay)
    {
        $users = [
            "admin" => User::find(1),
            "client" => User::find($pay->user_id),
        ];
        $pay->status == 0
        ? $this->cancelReserveNotification($users, $pay)
        : $this->successReserveNotification($users, $pay);
    }
    private function successReserveNotification($users, $pay)
    {
        try {
            $users["client"]->notify(new RealtimeNotification(
                title: 'Pago de reserva aceptado',
                message: 'Tu pago por la reserva #' . $pay->booking->booking_number . ' fue aprobada.',
                url: '/client/reserves/view/' . $pay->id,
                meta: [
                    'booking_id' => $pay->id,
                    'icon' => $pay->status_icon
                ]
            ));
        } catch (\Throwable $e) {
            // Silenciar errores de notificación para no romper el flujo
        }
    }
    private function cancelReserveNotification($users, $pay)
    {
        try {
            $users["client"]->notify(new RealtimeNotification(
                title: 'Pago de reserva rechazado',
                message: 'Tu pago por la reserva #' . $pay->booking->booking_number . ' fue rechazado.',
                url: '/client/reserves/view/' . $pay->id,
                meta: [
                    'booking_id' => $pay->id,
                    'icon' => $pay->status_icon
                ]
            ));
        } catch (\Throwable $e) {
            // Silenciar errores de notificación para no romper el flujo
        }
    }
}
