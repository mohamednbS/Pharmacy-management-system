<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modalite extends Model
{
    use HasFactory;
    use softDeletes; 


    protected $fillable = ['name'];

    /**
     * Get all of the comments for the Modalite
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function equipements(): HasMany
    {
        return $this->hasMany(Equipement::class);
    }

}
