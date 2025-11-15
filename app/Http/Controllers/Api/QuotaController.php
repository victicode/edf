<?php

namespace App\Http\Controllers\Api;

use App\Models\Quota;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $quotas = Quota::with(["pay", "departament.owner"])->orderBy('created_at', 'desc');

        // Filtrar por usuario si no es admin
        if ($request->user()->id != 1) {
            $quotas->whereHas('departament', function (Builder $query) use ($request) {
                $query->where('user_id', $request->user()->id);
            });
        }

        // Aplicar filtros
        // $this->applyPaysFilter($quotas, $request);

        return $this->returnSuccess(200, $quotas->get());
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
    public function show(string $id)
    {
        //
        $quota = Quota::with(["pay", "departament.owner"])->findOrFail($id);
        return $this->returnSuccess(200, $quota);
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
