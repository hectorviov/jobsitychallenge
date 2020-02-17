<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\HiddenTweet;
use App\Entry;
use GuzzleHttp\Client;

class UsersController extends Controller
{
    public function index($username) {
        $user = User::where('username', $username)->firstOrFail();

        $entries = Entry::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(3);
        return view('users.profile', ['entries' => $entries, 'user' => $user]);
    }

    public function tweets($username, Request $request) {
        $user = User::where('username', $username)->firstOrFail();
        $page = 1;
        if($request->query('page')) {
            $page = $request->query('page');
        }
        $options  = [
            'headers' => [
                'Authorization' => 'Bearer ' . env('TWITTER_TOKEN')
            ],
            'query' => [
                'screen_name' => $username,
                'count' => 5,
                'page' => $page
            ]
        ];
        $client = new Client([
            'base_uri' => 'https://api.twitter.com/1.1/',
        ]);
        $req = json_decode($client->request('GET', 'statuses/user_timeline.json', $options)->getBody());
        $hiddenTweets = DB::table('hidden_tweets')
                            ->where('user_id', $user->id)
                            ->pluck('tweet_id')
                            ->toArray();
        $tweets = [];
        foreach ($req as $tweet) {
            $arr = [
                $tweet->id => [
                    'text' => $tweet->text,
                    'date' => date('m-d-Y', strtotime($tweet->created_at)),
                    'hidden' => false
                ]
            ];
            if(in_array($tweet->id, $hiddenTweets)) {
                if(auth()->check()) {
                    if($user->id == auth()->user()->id) {
                        $arr[$tweet->id]['hidden'] = true;
                        array_push($tweets, $arr);
                    } 
                }
            } else {
                array_push($tweets, $arr);
            }
        }
        return response()->json($tweets);
    }

    public function toggleTweet($username, $id) {
        if(!$id) {
            App::abort(500, "You didn't specify a tweet.");
        }
        $resp = [
            'success' => true,
            'message' => '',
            'shown' => true
        ];
        $hiddenTweet = HiddenTweet::where('tweet_id', $id)->first();
        if($hiddenTweet) {
            if($hiddenTweet->delete()) {
                $resp['message'] = 'Tweet is shown.';
                $resp['shown'] = true;
                return response()->json($resp);
            } else {
                $resp['success'] = false;
                $resp['message'] = 'Tweet can\'t be shown, try again later.';
                $resp['shown'] = false;
                return response()->json($resp);
            }
        } else {
            $hiddenTweet = new HiddenTweet;
            $hiddenTweet->tweet_id = $id;
            $hiddenTweet->user_id = auth()->user()->id;
            if($hiddenTweet->save()) {
                $resp['message'] = 'Tweet is hidden.';
                $resp['shown'] = false;
                return response()->json($resp);
            } else {
                $resp['success'] = false;
                $resp['message'] = 'Tweet can\'t be hidden, try again later.';
                $resp['shown'] = true;
                return response()->json($resp);
            }
        }
    }
}
