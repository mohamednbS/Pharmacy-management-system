<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipement_name','client_name','souseq_name','type_panne','description_panne','priorite',
        'mode_appel','destinateur','soustritant_name','appel_client','observation','date_debut',
        'date_fin','etat','rapport'
    ];
}
