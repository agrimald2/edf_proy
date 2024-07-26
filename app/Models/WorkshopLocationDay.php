<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopLocationDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'LOCACION',
        'TALLER',
        'CONDICION',
        'TIEMPO',
    ];
}
