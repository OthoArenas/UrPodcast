<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function save(Request $request){

        /* Validación */
        $validate = $this->validate($request,[
            'post_id' => 'integer|required',
            'content' => 'string|required'
        ]);

        /* Recoger datos */
        $user = \Auth::user();
        $post_id = $request->input('post_id');
        $content = $request->input('content');

        /* Asginación de valores a objetos */
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->post_id = $post_id;
        $comment->content = $content;

        /* Guardar objeto en la Base de datos */
        $comment->save();

        /* Redirección */
        return redirect()->route('podcast.detail', [
            'id' => $post_id
        ])->with([
            'mensaje' => 'El comentario se ha publicado correctamente'
        ]);
    }

    public function delete($id){
        /* Conseguir datos de usuario identificado */
        $user = \Auth::user();
        /* Conseguir objeto del comentario */
        $comment = Comment::find($id);
        /* Comprobar si se es dueño del comentario o del post */
        if($user && ($comment->user_id == $user->id) || ($comment->post->user_id == $user->id)){
            $comment->delete();
            return redirect()->route('podcast.detail',[
                'id' => $comment->post->id
            ])->with([
                'mensaje' => 'Comentario borrado exitosamente'
            ]);
        }else{
            return redirect()->route('podcast.detail',[
                'id' => $comment->post->id
            ])->with([
                'mensaje' => 'El comentario no ha podido ser eliminado'
            ]);
        }
    }
}
