<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreatorProfile extends Model
{
    //
    protected $fillable = [
        'public_name',
        'slug',
        'bio',
        'avatar_url',
        'is_onboarded',
        'goal_title',
        'goal_amount',
    ];

    // Relación CreatorProfile 1: 1 Users
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function links() {
        return $this->hasMany(CreatorLink::class);
    }

    public function supports() {
        return $this->hasMany(Support::class);
    }
}
