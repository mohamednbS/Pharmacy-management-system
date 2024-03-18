<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Soustraitant extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'name','email','phone','fax','address'
    ];
}
