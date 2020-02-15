<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Entry;

class UsersController extends Controller
{
    public function index($username) {
        $user = User::where('username', $username)->firstOrFail();
        $entries = Entry::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(3);
        return view('users.profile', ['entries' => $entries, 'user' => $user]);
    }
}
