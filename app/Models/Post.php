<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
