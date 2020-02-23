<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Post;
use App\Comment;
use App\Like;

class PodcastController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('podcast.create');
    }

    public function save(Request $request)
    {

        /* Validación */
        $validates = $this->validate($request, [
            'description' => 'required',
            'post_path' => 'required|mimes:audio/mpeg,mpga,mp3,wav,aac'
        ]);

        /* Recoger datos */
        $post_path = $request->file('post_path');
        $description = $request->input('description');

        /* Asignar valores al objeto */
        $user = \Auth::user();
        $post = new Post();
        $post->user_id = $user->id;
        $post->description = $description;

        /* Subir fichero */
        if ($post_path) {
            $post_path_name = time() . $post_path->getClientOriginalName();
            Storage::disk('posts')->put($post_path_name, File::get($post_path));
            $post->post_path = $post_path_name;
        }

        /* Guardar objeto en la base de datos */
        $post->save();

        return redirect()->route('home')->with([
            'mensaje' => 'El podcast ha sido subido correctamente'
        ]);
    }

    public function getPost($filename)
    {
        $filename = Storage::disk('posts')->get($filename);
        return new Response($filename, 200);
    }

    public function detail($id)
    {
        $post = Post::find($id);
        return view('podcast.detail', [
            'post' => $post
        ]);
    }

    public function delete($id)
    {
        $user = \Auth::user();
        $post = Post::find($id);
        $comments = Comment::where('post_id', $id)->get();
        $likes = Like::where('post_id', $id)->get();

        if ($user && $post && $post->user->id == $user->id) {
            /* Eliminar comentarios */
            if ($comments && count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }
            /* Eliminar likes */
            if ($likes && count($likes) >= 1) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }
            /* Eliminar Ficheros podcast */
            Storage::disk('posts')->delete($post->post_path);
            /* Eliminar Registros */
            $post->delete();

            $mensaje = array('mensaje' => 'El podcast se ha borrado correctamente');
        } else {
            $mensaje = array('mensaje' => 'El podcast no se ha borrado correctamente');
        }

        return redirect()->route('home')->with($mensaje);
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::find($id);

        if ($user && $post && $post->user->id == $user->id) {
            return view('podcast.edit', ['post' => $post]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        /* Validación */
        $validates = $this->validate($request, [
            'description' => 'required|string',
            'post_path' => 'mimes:audio/mpeg,mpga,mp3,wav,aac'
        ]);

        $post_id = $request->input('post_id');
        $description = $request->input('description');
        $post_path = $request->file('post_path');

        /* Conseguir objeto post */
        $post = Post::find($post_id);
        $post->description = $description;

        /* Eliminar fichero de audio */
        if ($post_path) {
            Storage::disk('posts')->delete($post->post_path);
        }

        /* Subir fichero */
        if ($post_path) {
            $post_path_name = time() . $post_path->getClientOriginalName();
            Storage::disk('posts')->put($post_path_name, File::get($post_path));
            $post->post_path = $post_path_name;
        }

        /* Actualizar objeto */
        $post->update();

        return redirect()->route('podcast.detail', ['id' => $post_id])->with([
            'mensaje' => 'Podcast actualizado correctamente'
        ]);
    }
}
