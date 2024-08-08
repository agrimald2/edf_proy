<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PermutasExport implements FromView
{
    protected $permutas;

    public function __construct($permutas)
    {
        $this->permutas = $permutas;
    }

    public function view(): View
    {
        return view('exports.permutas', [
            'permutas' => $this->permutas
        ]);
    }
}