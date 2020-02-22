<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    /* Indica la tabla que modificará el modelo */
    protected $table = 'likes';
    /* Relación Muchos a Uno */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    /* Relación Muchos a Uno */
    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }
}
