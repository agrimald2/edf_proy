<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;
use DB;

class TradeController extends Controller
{
    public function index(){     
        return Inertia::render('Trade/Permutas/List', [
                'supervisor' => 'Alonso',
        ]); 
    } 
}
