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
        'instance_status',
        'supervisor_status',
        'supervisor_approved_by',
        'supervisor_approved_at',
        'supervisor_rejected_reason',
        'supervsior_rejected_comments',
        'gerente_status',
        'gerente_approved_by',
        'gerente_approved_at',
        'gerente_rejected_reason',
        'gerente_rejected_comments',
        'trade_status',
        'trade_approved_by',
        'trade_approved_at',
        'trade_rejected_reason',
        'trade_rejected_comments',
    ];
}