<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entry;

class EntriesController extends Controller
{
    public function add(Request $request) {
        
        if($request->isMethod('post')) {
            $request->validate([
                'title' => ['required', 'max:191'],
                'content' => ['required']
            ]);

            Entry::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'user_id' => auth()->user()->id
            ]);

            return redirect()->action('UsersController@index', ['username' => auth()->user()->username]);
        }
        
        return view('entries.add');
    }

    public function edit($id, Request $request) {
        $entry = Entry::findOrFail($id);
        if($entry->user_id != auth()->user()->id) {
            return back()->with('error', "You can't edit other peoples' entries.");
        }
        if($request->isMethod('post')) {
            $request->validate([
                'content' => ['required']
            ]);
            $entry->content = $request->input('content');
            if(!$entry->save()) {
                App::abort(500, 'Entry could not be saved, try again later.');
            }
            return redirect()->action('UsersController@index', ['username' => auth()->user()->username]);
        }
        return view('entries.edit', ['entry' => $entry]);
    }
}
