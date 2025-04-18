<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Permuta;
use App\Models\EdfData;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PendingPermutasExport;
use Illuminate\Support\Facades\Log;
class TradeController extends Controller
{
    public function index()
    {
        return Inertia::render('Trade/Permutas/List', [
            'supervisor' => 'Alonso',
        ]);
    }

    public function exportPendingPermutas()
    {
        $permutas = Permuta::where('instance_status', 'Trade')
            ->where('trade_status', 'PENDING')
            ->with(['location' => function($query) {
                $query->select('id', 'name');
            }])
            ->get([
                'id',
                'cod_cliente',
                'created_at as fecha_de_permuta',
                'volume as volumen_en_cu',
                'condition as condición',
                'doors_to_negotiate as puertas_a_negotiar',
                'reason as motivo',
                'justification as justificación',
                'subcanal as subcanal',
                'trade_status as status',
                'location_id'
            ])->map(function ($permuta) {
                $permuta->locacion = $permuta->location ? $permuta->location->name : null;
                unset($permuta->location);
                return $permuta;
            });

        $permutas->map(function ($permuta) {
            $edfData = EdfData::where('id', $permuta->cod_cliente)->first(['n_edf', 'n_doors']);
            $permuta->n_edf = $edfData ? $edfData->n_edf : '';
            $permuta->n_doors = $edfData ? $edfData->n_doors : '';
            $permuta->status = 'PENDIENTE';
            return $permuta;
        });

        return Excel::download(new PendingPermutasExport($permutas), 'pending_permutas.xlsx');
    }

    public function importPendingPermutas(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        $data = Excel::toArray([], $file)[0];
        
        foreach ($data as $index => $row) {
            // Skip the header row
            if ($index === 0) {
                continue;
            }

            $permuta = Permuta::find($row[0]);
            if ($permuta) {
                if (strtoupper($row[12]) === 'SI') {
                    $permuta->trade_status = 'Approved';
                    $permuta->trade_approved_at = now();
                } elseif (strtoupper($row[12]) === 'NO') {
                    $permuta->trade_status = 'Rejected';
                    $permuta->trade_rejected_at = now();
                }
                $permuta->save();
            }
        }

        return response()->json(['message' => 'Permutas processed successfully']);
    }
}
