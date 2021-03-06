<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['created_at_human', 'reopinion_created_at'];

    protected $casts = ['created_at' => 'datetime:H:i · M d, Y'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Opinion::class, 'parent_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->latest();
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
        }

        return "";
    }

    public function getReopinionCreatedAtAttribute()
    {
        if ($this->created_at) {
            return $this->created_at;
        }

        return "";
    }

    public static function checkOpinion($id)
    {
        return Opinion::where('id', $id)->count() > 0;
    }
}
