<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function edit($id)
    {
        try {

            $user = User::where('id', $id)->get();

            return view('admin.pages.user', compact('user'));

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function teste_email()
    {
        $urlToken = 'http://127.0.0.1/1221sqd123vweqe1v';

        return view('email.resetPassword', compact('urlToken'));
    }
}
