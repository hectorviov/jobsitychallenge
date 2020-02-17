<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entry;

class PagesController extends Controller
{
    public function index() {
        $entries = Entry::orderBy('created_at', 'desc')
                    ->orderBy('id', 'desc')
                    ->paginate(3);
        return view('welcome', ['entries' => $entries]);
    }
}
