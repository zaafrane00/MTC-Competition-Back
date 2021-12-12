<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = [
        'nom'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
