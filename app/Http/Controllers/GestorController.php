<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;
use DB;
use Log;

class GestorController extends Controller
{
    public function showPermutasList($route){                     
        return Inertia::render('Gestor/Permutas/List', [
                'supervisor' => 'Alonso',
                'mesa' => 'A',
                'route' => $route,
                'haveAvailableLimit' => true
        ]); 
    } 
}
