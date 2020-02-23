<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Post;
use App\Broadcast;
use App\Comment;
use App\Like;

class BroadcastController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('broadcast.create');
    }

    public function save(Request $request)
    {

        /* Validación */
        $validates = $this->validate($request, [
            'title' => 'required|string',
            'post_path' => 'required|mimes:audio/mpeg,mpga,mp3,wav,aac',
            'description' => 'required|string',
            'starts_at' => 'required|date'
        ]);

        /* Recoger datos */
        $title = $request->input('title');
        $post_path = $request->file('post_path');
        $description = $request->input('description');
        $starts_at = $request->input('starts_at');

        /* Asignar valores al objeto */
        $user = \Auth::user();
        $broadcast = new Broadcast();
        $broadcast->user_id = $user->id;
        $broadcast->description = $description;
        $broadcast->title = $title;
        $broadcast->starts_at = $starts_at;

        /* Subir fichero */
        if ($post_path) {
            $post_path_name = time() . $post_path->getClientOriginalName();
            Storage::disk('posts')->put($post_path_name, File::get($post_path));
            $broadcast->post_path = $post_path_name;
        }

        /* Guardar objeto en la base de datos */
        $broadcast->save();

        return redirect()->route('home')->with([
            'mensaje' => 'La transmisión en vivo ha sido creada exitosamente'
        ]);
    }

    public function detail($id)
    {
        $broadcast = Broadcast::find($id);
        return view('broadcast.detail', [
            'broadcast' => $broadcast
        ]);
    }

    public function delete($id)
    {
        $user = \Auth::user();
        $broadcast = Broadcast::find($id);

        if ($user && $broadcast && $broadcast->user->id == $user->id) {
            /* Eliminar Ficheros podcast */
            Storage::disk('posts')->delete($broadcast->post_path);
            /* Eliminar Registros */
            $broadcast->delete();

            $mensaje = array('mensaje' => 'La transmisión se ha borrado correctamente');
        } else {
            $mensaje = array('mensaje' => 'La transmisión no se ha borrado correctamente');
        }

        return redirect()->route('home')->with($mensaje);
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $broadcast = Broadcast::find($id);

        if ($user && $broadcast && $broadcast->user->id == $user->id) {
            return view('broadcast.edit', ['broadcast' => $broadcast]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        /* Validación */
        $validates = $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required|string',
            'starts_at' => 'required|date',
            'post_path' => 'mimes:audio/mpeg,mpga,mp3,wav,aac'
        ]);

        $title = $request->input('title');
        $broadcast_id = $request->input('broadcast_id');
        $description = $request->input('description');
        $starts_at = $request->input('starts_at');
        $post_path = $request->file('post_path');

        /* Conseguir objeto broadcast */
        $broadcast = Broadcast::find($broadcast_id);
        $broadcast->description = $description;
        $broadcast->title = $title;
        $broadcast->starts_at = $starts_at;

        /* Eliminar fichero de audio */
        if ($post_path) {
            Storage::disk('posts')->delete($broadcast->post_path);
        }

        /* Subir fichero */
        if ($post_path) {
            $post_path_name = time() . $post_path->getClientOriginalName();
            Storage::disk('posts')->put($post_path_name, File::get($post_path));
            $broadcast->post_path = $post_path_name;
        }

        /* Actualizar objeto */
        $broadcast->update();

        return redirect()->route('broadcast.detail', ['id' => $broadcast_id])->with([
            'mensaje' => 'La transmisión ha sido actualizada correctamente'
        ]);
    }

    public function end($id)
    {
        $user = \Auth::user();
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

            $mensaje = array('mensaje' => 'La transmisión se ha concluidoo correctamente. Ahora puedes encontrar esta grabación en un nuevo Podcast.');
        } else {
            $mensaje = array('mensaje' => 'La transmisión no se ha concluido correctamente');
        }

        return redirect()->route('home')->with($mensaje);
    }
}
