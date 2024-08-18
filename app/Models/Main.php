<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'COD_CLIENTE',
        'RUTA',
        'FREC_VISITA',
        'CLIENTE',
        'DIRECCION',
        'SV',
        'GV',
        'NOMBRE_SV',
        'TAMANO',
        'PROMEDIO_CU_3M',
        'N_EDF',
        'N_PUERTAS',
        'CONDICION',
        'PUERTAS_A_NEGOCIAR',
        'CONDICION_2',
        'PUERTAS_A_NEGOCIAR_2',
        'NEGOCIADO',
        'STATUS',
        'CUOTA',
        'SV_LIMIT',
        'LOCACION',
        'TALLER',
        'FECHA_NEGOCIADO',
        'PROMEDIO_MES',
        'EDF_NEGOCIADOS'
    ];
}
