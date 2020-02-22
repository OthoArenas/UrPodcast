<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /* Indica la tabla que modificará el modelo */
    protected $table = 'comments';
    /* Relación Muchos a Uno */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    /* Relación Muchos a uno */
    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }
}
