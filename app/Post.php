<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /* Indica la tabla que modificará el modelo */
    protected $table =  'posts';
    /* Relación de Uno a Muchos */
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('id','desc');
    }
    /* Relación de Uno a Muchos */
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
    /* Relación Muchos a Uno */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
