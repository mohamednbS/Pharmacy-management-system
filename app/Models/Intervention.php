<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intervention extends Model
{
    use HasFactory;
    use softDeletes;


    protected $casts = [
        'destinateur' => 'array',
    ];

    protected $fillable = [
        'equipement_id','client_id','sousequipement_id','etat_initial','description_panne','priorite',
        'mode_appel','destinateur','soustritant_id','appel_client','description_intervention','observation','date_debut',
        'date_fin','etat_final','etat','rapport'
    ];
    public function client(){

        return $this->belongsTo(Client::class);
    }

    public function equipement(){

        return $this->belongsTo(Equipement::class);
    }

    public function sousequipement(){

        return $this->belongsTo(Sousequipement::class);
    }
    public function soustraitant(){

        return $this->belongsTo(Soustraitant::class);
    }

}
