<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id','equipement_id','date_debut','date_fin',
        'type_contrat','status','note'
    ];

    public function client(){

        return $this->belongsTo(Client::class);
    }

    public function equipement(){

        return $this->belongsTo(Equipement::class);
    }

}
