<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileFormRequest;

class UserController extends Controller
{

    public function profile()
    {
        return view('site.profile.profile');
    }

    public function profileUpdate(UpdateProfileFormRequest $request)
    {

        $data = $request->all();
        $user = auth()->user();


        if ($data['password'] != null) {
            $data['password'] = \bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $name = $user->id . kebab_case($user->name);
            $extension = $request->image->extension();
            $nameFile = "{$name}.{$extension}";

            $data['image'] = $nameFile;

            $upload = $request->image->storeAs('users', $nameFile);
            if (!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Erro ao fazer upload da imagem');
            }
        }



        $update = auth()->user()->update($data);

        if ($update) {
            return redirect()
                ->route('profile')
                ->with('success', 'Usuário editado com sucesso');
        }

        return redirect()
            ->route('profile')
            ->with('error', 'Falha ao editar o usuario');

    }


}
