<?php

namespace App\Http\Controllers;

use App\Models\Quota;
use Illuminate\Http\Request;

class QuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $pays = Quota::with(["pay", "departament.user"]);

        // Filtrar por usuario si no es admin
        if ($request->user()->id != 1) {
            $pays->where('user_id', $request->user()->id);
        }

        // Aplicar filtros
        // $this->applyPaysFilter($pays, $request);

        return $this->returnSuccess(200, $pays->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Quota $quota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quota $quota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quota $quota)
    {
        //
    }
}
