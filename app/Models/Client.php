<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','email','phone','company',
        'address','product','comment'
    ];

    /**
     * Get all of the comments for the clients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipements(): HasMany
    {
        return $this->hasMany(Equipement::class);
    }

     /**
	 * Has Many Through relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\hasManyThrough
	 */
	public function sousequipements()
	{
		return $this->hasManyThrough('App\Models\Sousequipement', 'App\Models\Equipement');
	}
}
