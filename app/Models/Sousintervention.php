<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sousintervention extends Model
{
    use HasFactory;
    use softDeletes;

    protected $casts = [
        'intervenant' => 'array',
    ];

    protected $fillable = [
        'date_debut','date_fin','etat_initial','description_panne','intervenant','description_sousintervention','intervention_id'
    ];

    public function intervention(){

        return $this->belongsTo(Intervention::class);
    }

}

