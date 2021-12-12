<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = [
        'title', 'body', 'image', 'image_thumbnail', 'user_id', 'status', 'type',
        'address', 'country_id'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
