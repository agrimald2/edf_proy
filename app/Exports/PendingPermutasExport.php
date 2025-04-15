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
    }

    public function view(): View
    {
        return view('exports.pending_permutas', [
            'permutas' => $this->permutas
        ]);
    }
}
