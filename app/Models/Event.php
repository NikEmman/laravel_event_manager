<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'space_id',
        'start_date',
        'end_date'
    ];
    //relations
    public function space(): BelongsTo
{
    
    return $this->belongsTo(Space::class);
}
}
