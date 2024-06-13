<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;
use DB;

class GerenteController extends Controller
{
    public function getInfoByMesa(){     
        # Nombre de Supervisor campo en DB
        return Inertia::render('Gerente/InfoByMesa', [
                'supervisor' => 'Alonso',
        ]); 
    } 

    public function showPermutasList(){     
        return Inertia::render('Gerente/Permutas/List', [
                'supervisor' => 'Alonso',
        ]); 
    } 
}
