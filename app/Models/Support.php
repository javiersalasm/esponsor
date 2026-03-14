<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    //
    protected $fillable = [
        'creator_profile_id',
        'supporter_name',
        'message',
        'amount',
    ];

    // Relación: CreatorProfile 1 : N Support
    public function creatorProfile() {
        return $this->belongsTo(CreatorProfile::class);
    }
    
}
