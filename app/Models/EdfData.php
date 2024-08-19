<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdfData extends Model
{
    use HasFactory;

    protected $table = 'edf_data';
    protected $fillable = [
        'code',
        'n_edf',
        'n_doors'
    ];
}
