<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reopinion extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['created_at_human'];

    protected $casts = ['created_at' => 'datetime:H:i · M d, Y'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reuser()
    {
        return $this->belongsTo(User::class, 'reopinion_user_id');
    }

    public function parent()
    {
        return $this->belongsTo(Opinion::class, 'parent_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'opinion_id')->latest();
    }

    public function replies()
    {
        return $this->hasMany(Opinion::class, 'parent_id')->latest();
    }

    public function reopinions()
    {
        return $this->hasMany(Reopinion::class, 'id')->latest();
    }

    public function getCreatedAtHumanAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->diffForHumans();
        } else {
            return "";
        }
    }
}
