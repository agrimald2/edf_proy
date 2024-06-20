<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;
use DB;

class SupervisorController extends Controller
{
    public function getInfoByMesa(){     
        # Nombre de Supervisor campo en DB
        return Inertia::render('Supervisor/InfoByMesa', [
                'supervisor' => 'Alonso',
        ]); 
    } 

    public function showPermutasList($mesa){     
        return Inertia::render('Supervisor/Permutas/List', [
                'supervisor' => 'Alonso',
                'mesa' => $mesa,
        ]); 
    } 
}
