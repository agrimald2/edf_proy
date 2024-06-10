<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permuta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cod_cliente',
        'volume',
        'location',
        'route',
        'subcanal',
        'have_edf',
        'condition',
        'doors_to_negotiate',
        'reason',
    ];
}