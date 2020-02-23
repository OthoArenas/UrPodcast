<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Broadcast;
use App\Http\Controllers\BroadcastController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(5);
        $broadcasts = Broadcast::orderBy('starts_at', 'asc')->paginate(5);

        /* Terminar automáticamentebroadcast si ha caducado su tiempo */
        /* foreach ($broadcasts as $broadcast) {
            if (strtotime(now()) >= (strtotime($broadcast->starts_at) + 4500)) {
                end($broadcast->id);
            }
        } */

        return view('home', [
            'posts' => $posts,
            'broadcasts' => $broadcasts
        ]);
    }
}
