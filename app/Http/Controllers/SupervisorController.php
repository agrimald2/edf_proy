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

    public function getSupervisorLimit($sv){
        $sv_limit = Main::where('SV', $mesa)->first()->SV_LIMIT ?? 0; 
    }
}
