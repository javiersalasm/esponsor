<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreatorLink extends Model
{
    //
    protected $fillable = [
        'creator_profile_id',
        'title',
        'url',
        'order',
    ];

    // Relación: CreatorProfile 1 : N CreatorLink
    public function creatorProfile() {
        return $this->belongsTo(CreatorProfile::class);
    }
}
