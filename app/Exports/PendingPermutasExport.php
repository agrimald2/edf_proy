<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Log;

class PendingPermutasExport implements FromView
{
    protected $permutas;

    public function __construct($permutas)
    {
        $this->permutas = $permutas;
        Log::info($this->permutas); // Log permutas in the constructor
    }

    public function view(): View
    {
        return view('exports.pending_permutas', [
            'permutas' => $this->permutas
        ]);
    }
}
