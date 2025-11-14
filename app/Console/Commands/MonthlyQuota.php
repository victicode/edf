<?php

namespace App\Console\Commands;

use App\Models\Departament;
use App\Models\Quota;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MonthlyQuota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:monthly-quota';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera las coutas de mensualidad del condominio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $departaments  = $this->getAllDepartamentsId();
        $month = $this->getCurrentMonth();

        foreach ($departaments as $departament) {
            $this->makeQuotaOfMonth($departament, $month);
        }
    }
    private function getAllDepartamentsId()
    {
        return Departament::select('id', 'number')->has('owner')->get();
    }
    private function getCurrentMonth()
    {
        return date('n');
    }
    private function labelMonth($monthIndex)
    {
        $months = [
            '',
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        ];
        return $months[$monthIndex];
    }
    private function makeQuotaOfMonth($departament, $month)
    {
        if ($this->checkIfNoPayQuota($departament->id, $month)) {
            try {
                Quota::create([
                    'departament_id' => $departament->id,
                    'amount' => 300,
                    'number' => 'A' . substr($departament->number, -3) . '-' . $month . rand(1000, 9999),
                    'month' => $month,
                    'due_date' =>  date('Y') . '-' . $month . '-10',
                    'type' => 1,
                    'description' => 'Cuota mensual: mes ' . $this->labelMonth($month),
                    'status' => 1
                ]);
            } catch (Exception $th) {
                return $th->getMessage();
            }
        }
    }
    private function checkIfNoPayQuota($departamentId, $month)
    {
        $quota = Quota::where('departament_id', $departamentId)->where('month', $month)->first();
        return !($quota);
    }
}
