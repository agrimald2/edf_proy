<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;
use App\Models\Location;
use App\Models\Permuta;
use App\Models\EdfData;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Exports\PendingPermutasExport;
use Illuminate\Support\Facades\Log;
class GerenteController extends Controller
{
    public function getInfoByMesa(){     
        # Nombre de Supervisor campo en DB
        return Inertia::render('Gerente/InfoByMesa', [
                'supervisor' => 'Alonso',
        ]); 
    } 

    public function index(){     
        return Inertia::render('Gerente/Permutas/List', [
                'supervisor' => 'Alonso',
        ]); 
    } 

    public function showPermutasPendingList(){     
        return Inertia::render('Gerente/Permutas/PendingApproval', [
                'supervisor' => 'Alonso',
        ]); 
    } 

    public function getGerenteLocations() {
        $user = Auth::user();
        $userId = Auth::id();
        $locations = Location::where('user_id', $userId)->get();


        return response()->json($locations);
    }

    public function getPermutasPendingList()
    {
        $user = Auth::user();

        $permutas = Permuta::whereIn('instance_status', ['Gerente', 'Trade'])
                            ->with(['location', 'location.subregion'])
                            ->whereHas('location', function ($query) use ($user) {
                                $query->where('user_id', $user->id);
                            })
                            ->get();
        
        return response()->json($permutas);
    }

    public function exportPendingPermutas()
    {
        $user = Auth::user();
        $permutas = Permuta::where('instance_status', 'Gerente')
            ->where('gerente_status', 'PENDING')
            ->with(['location' => function($query) {
                $query->select('id', 'name');
            }])
            ->whereHas('location', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
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
                'gerente_status as status',
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

        return Excel::download(new PendingPermutasExport($permutas), 'pending_permutas_gerente.xlsx');
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
                    $permuta->gerente_status = 'Approved';
                    $permuta->gerente_approved_at = now();
                } elseif (strtoupper($row[12]) === 'NO') {
                    $permuta->gerente_status = 'Rejected';
                    $permuta->gerente_rejected_at = now();
                }
                $permuta->save();
            }
        }

        return response()->json(['message' => 'Permutas processed successfully']);
    }
}