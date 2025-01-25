<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = [  //代入するカラムが増えたらどんどん記載していく
        'title',
        'body',
    ];
    //
    public function user()
    {
        return $this->belongsTo(User::class); //作成
    }
    //public function image_url() (1)こちらでも良い
    public function getImageUrlAttribute()
    {
        return Storage::url('images/posts/' . $this->image); //作成
    }
}
