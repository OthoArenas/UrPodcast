<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
/* Para poder usar Auth::user(); */
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;
use App\Broadcast;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        /* Validación */
        $validate = $this->validate($request, [
            'search' => ['string', 'max:255']
        ]);

        /* Recoger datos */
        $search = $request->input('search');

        /* Consulta de usuarios */
        if (!empty($search)) {
            $users = User::where('username', 'LIKE', '%' . $search . '%')->orWhere('name', 'LIKE', '%' . $search . '%')->orWhere('surname', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->paginate(5);
        } else {
            $users = User::orderBy('id', 'desc')->paginate(5);
        }

        return view('user.index', ['users' => $users]);
    }

    public function config()
    {
        return view('user.config');
    }

    public function update(Request $request)
    {
        /* Conseguir usuario identificado */
        $user = Auth::user();
        $id = $user->id;

        /* Validación del formulario */
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
        ]);

        /* Recoger datos del formulario */
        $name = $request->input('name');
        $surname = $request->input('surname');
        $username = $request->input('username');
        $email = $request->input('email');

        /* Asignar nuevos valores al objeto usuario */
        $user->name = $name;
        $user->surname = $surname;
        $user->username = $username;
        $user->email = $email;

        /* Subir imagen */
        $image_path = $request->file('image_path');
        if ($image_path) {
            /* Borrar del storage foto anterior */
            $old_image = $user->image;
            if ($old_image != 'default-user.jpg') {
                Storage::disk('users')->delete($old_image);
            }

            /* Poner nombre único */
            $image_path_name = time() . $image_path->getClientOriginalName();

            /* Guardar en la carpeta storage/app/users */
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            /* Setea en base de datos el valor de la imagen */
            $user->image = $image_path_name;
        }

        /* Ejecutar consulta y cambios en la base de datos */
        $user->update();

        return redirect()->route('config')
            ->with(['mensaje' => 'Usuario actualizado correctamente']);
    }

    public function getImage($filename)
    {
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }

    public function profile($id)
    {
        $user = User::find($id);
        $broadcasts = Broadcast::where('user_id', $user->id)->orderBy('starts_at', 'asc')->paginate(5);

        return view('user.profile', ['user' => $user, 'broadcasts' => $broadcasts]);
    }
}
