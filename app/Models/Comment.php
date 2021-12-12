<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = [
        'body', 'image',
        'user_id', 'comment_id',

    ];

    public function owner()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function replies()
    {
        return $this->hasMany('App\Model\Comment', 'comment_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
