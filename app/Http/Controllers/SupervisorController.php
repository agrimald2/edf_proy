<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;
use DB;
use Log;

class SupervisorController extends Controller
{
    public function getInfoByMesa(){     
        # Nombre de Supervisor campo en DB
        return Inertia::render('Supervisor/InfoByMesa', [
                'supervisor' => 'Alonso',
        ]); 
    } 

    public function showPermutasList($mesa){     
        $sv_limit = Main::where('SV', $mesa)->first()->SV_LIMIT ?? 0; 
        $approved_permutas_count = DB::table('permutas')->where('supervisor_approved_by', $mesa)->count();
        
        $haveAvailableLimit = ($sv_limit - $approved_permutas_count) > 0;
                
        return Inertia::render('Supervisor/Permutas/List', [
                'supervisor' => 'Alonso',
                'mesa' => $mesa,
                'haveAvailableLimit' => $haveAvailableLimit
        ]); 
    } 

    public function showPermutasPendingList($mesa){     
        $mesa = strtoupper($mesa);
        $cuota = Main::where('SV', $mesa)->first()->CUOTA ?? 'N/A';
        $supervisor = Main::where('SV', $mesa)->first()->NOMBRE_SV ?? 'N/A';
        $clients = Main::where('SV', $mesa)->get();
        
        $gestores = Main::select('RUTA', 'GV')
            ->where('SV', 'LIKE', $mesa)
            ->distinct()
            ->get()
            ->map(function($gestor) {
                $ruta = $gestor->RUTA;
                $gv = $gestor->GV;
                $total_negociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'NEGOCIADO')->count();
                $n_puertas_negociadas_repotenciadas = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'NEGOCIADO')->where('CONDICION', 'REPOTENCIADO')->sum('PUERTAS_A_NEGOCIAR');
                $n_puertas_negociadas_nuevas = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'NEGOCIADO')->where('CONDICION', 'NUEVO')->sum('PUERTAS_A_NEGOCIAR');

                return [
                    'ruta' => $ruta,
                    'gv' => $gv,
                    'total_negociados' => $total_negociados,
                    'n_puertas_negociadas_repotenciadas' => $n_puertas_negociadas_repotenciadas,
                    'n_puertas_negociadas_nuevas' => $n_puertas_negociadas_nuevas,
                ];
            })
            ->sortBy('total_negociados')
            ->values();

        
        $negociados = Main::where('SV', $mesa)->where('NEGOCIADO', 'NEGOCIADO')->count();
        $noNegociados = Main::where('SV', $mesa)->where('NEGOCIADO', 'PENDIENTE')->count();

        
        $gv = Main::where('SV', $mesa)->first()->GV ?? 'N/A';
        $pending = is_numeric($cuota) ? $cuota - $negociados : 'N/A';
        if (is_numeric($pending) && $pending < 0) {
            $pending = 0; // Ensure pending is not negative
        }

        // get progress percentage between $negociados and cuota

        $progress = is_numeric($cuota) && $cuota > 0 ? ($negociados / $cuota) * 100 : 0;
        
        return Inertia::render('Supervisor/Permutas/PendingApproval', [
            'mesa' => $mesa,
            'clients' => $clients,
            'negociados' => $negociados,
            'noNegociados' => $noNegociados,
            'gv' => $gv,
            'cuota' => $cuota, 
            'pending' => $pending,
            'progress' => $progress,
            'gestores' => $gestores,
            'supervisor' => $supervisor
        ]); 
    } 

    public function getSupervisorLimit($sv){
        $sv_limit = Main::where('SV', $mesa)->first()->SV_LIMIT ?? 0; 
    }
}
