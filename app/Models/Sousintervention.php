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
<<<<<<< HEAD
        'date_debut','date_fin','etat_initial','description_panne','intervenant','description_sousintervention','intervention_id',
        'etat_final'
=======
        'date_debut','date_fin','etat_initial','description_panne','intervenant','description_sousintervention','intervention_id'
>>>>>>> 816b1807b58c6fc01cc6ab3d882d09137fb29973
    ];

    public function intervention(){

        return $this->belongsTo(Intervention::class);
    }

}

