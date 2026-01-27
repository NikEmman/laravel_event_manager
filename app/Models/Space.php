<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Space extends Model
{
    protected $fillable = [
        'name',
        'address',
        
    ];
    //relations
    public function events(): HasMany
{
    return $this->hasMany(Event::class);
}
}
