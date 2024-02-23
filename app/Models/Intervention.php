<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Intervention extends Model
{
    use HasFactory;

    protected $casts = [
        'destinateur' => 'array',
    ];
 
    protected $fillable = [
        'equipement_name','client_name','souseq_name','type_panne','description_panne','priorite',
        'mode_appel','destinateur','soustritant_name','appel_client','description_intervention','observation','date_debut',
        'date_fin','etat','rapport'
    ];
    public function clients(): MorphToMany
    {
        return $this->morphToMany(Client::class);
    }
}
