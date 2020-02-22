<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $user = \Auth::user();
        $likes = Like::where('user_id',$user->id)->orderBy('id','desc')->paginate(5);

        return view('like.index',[
            'likes' => $likes
        ]);
    }

    public function like($post_id){
        /* Recoger datos de usuario y post */
        $user = \Auth::user();

        /* Condición para saber si ya existe el Like */
        $isset_like = Like::where('user_id', $user->id)->where('post_id', $post_id)->count();

        if($isset_like == 0){
            /* Crear objeto Like */
            $like = new Like();
    
            /* Asignar valores al objeto */
            $like->user_id = $user->id;
            $like->post_id = (int)$post_id;
    
            /* Guardar en Base de datos */
            $like->save();

            return response()->json([
                'like' => $like
            ]);

            /* Regresa a la misma página después del guardado en BD */
            /* return back(); */

        }else{
            return response()->json([
                'mensaje' => 'El like ya existe'
            ]);
        }
    }
    
    public function dislike($post_id){
        /* Recoger datos de usuario y post */
        $user = \Auth::user();

        /* Condición para saber si ya existe el Like */
        $like = Like::where('user_id', $user->id)->where('post_id', $post_id)->first();

        if($like){
            /* Eliminar en Base de datos */
            $like->delete();

            return response()->json([
                'like' => $like,
                'mensaje' => 'Ya no te gusta el post'
            ]);

            /* Regresa a la misma página después del borrado en BD */
            /* return back(); */
            
        }else{
            return response()->json([
                'mensaje' => 'El like no existe'
            ]);
        }
    }

    
}
