<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermutaRejectedReason;

class PermutaRejectedReasonController extends Controller
{
    public function index()
    {
        $permuta_rejected_reasons = PermutaRejectedReason::all();
        return response()->json($permuta_rejected_reasons);
    }

}
