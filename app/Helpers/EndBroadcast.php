<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Broadcast;
use App\Post;
use Illuminate\Support\Facades\Auth;

class EndBroadcast
{

    public static function EndBroadcast($id)
    {
        $user = Auth::user();
        $broadcast = Broadcast::find($id);

        /* CREACIÓN DE PODCAST */

        /* Recoger datos */
        $post_path = $broadcast->post_path;
        $description = $broadcast->description;

        /* Asignar valores al objeto */
        $post = new Post();
        $post->user_id = $user->id;
        $post->description = $description;

        /* Subir fichero */
        if ($post_path) {
            $post->post_path = $post_path;
        }

        /* Guardar objeto en la base de datos */
        $post->save();

        /* ELIMINACIÓN DE BROADCAST */

        if ($user && $broadcast && $broadcast->user->id == $user->id) {
            /* Eliminar Registros */
            $broadcast->delete();
        }

        return redirect()->route('home');
    }
}
