<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use File;
use App\Models\Event;
use App\Models\Thread;
use App\Models\Category;
use App\Models\Location;
use App\Models\FeedResult;
use App\Models\Image;
use App\Models\Action;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class PlacesController extends Controller
{
    public static function index(){
        return view('places.index');
    }

    public function FindEvents(Request $req){
        $userFriends = Auth::user()->acceptedFriendsTo->merge(Auth::user()->acceptedFriendsFrom)->sortBy('friends.created_at');
        $friendsIds = array();
        foreach($userFriends as $friend){
            $friendsIds[] = $friend->id;
        }
        $results = FeedResult::join('users', 'feed_results.owner_id', 'users.id')
        ->join('stays', 'users.id', 'stays.user_id')
        ->join('schools', 'stays.destination_school_id', 'schools.id')
        ->where('feed_results.type', 'events')
        // ->where('feed_results.start_datetime', '>', \Carbon\Carbon::now())
        ->where('feed_results.created_at', '>', \Carbon\Carbon::now()->subDays(300))
        ->where(function($q) use($friendsIds){
            $q->where(function($q2) use($friendsIds){
                $q2->where('public', 0)
                ->whereIn('owner_id', $friendsIds);
            })
            ->orWhere('public', 1)
            ->orWhere('owner_id', Auth::user()->id);
            
        })
        ->skip($req->skip)
        ->take(10)
        ->select('feed_results.*', 'feed_results.slug as event_slug')
        ->orderBy('feed_results.created_at', 'DESC')
        ->get();


        return \Response::json(
                $results
            , 200);
    }

    public function ShowEvent(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'event' => 'required|exists:feed_results,slug',
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }

            $userFriends = Auth::user()->acceptedFriendsTo->merge(Auth::user()->acceptedFriendsFrom)->sortBy('friends.created_at');
            $friendsIds = array();
            foreach($userFriends as $friend){
                $friendsIds[] = $friend->id;
            }
            $event = Event::join('feed_results', 'events.id', 'feed_results.result_id')
            ->where('feed_results.type', 'events')->where('feed_results.slug', $req->event) 
            ->where(function($q) use($friendsIds){
                $q->where(function($q2) use($friendsIds){
                    $q2->where('feed_results.public', 0)
                    ->whereIn('feed_results.owner_id', $friendsIds);
                })
                ->orWhere('feed_results.public', 1)
                ->orWhere('feed_results.owner_id', Auth::user()->id);
                
            })
            ->firstOrFail();

            return view('places.event-card', ['event' => $event]);

        } catch (\Throwable $th) {
            return view('places.event-card', ['content' => 'CONTENIDO', 'title' => 'Sin conexión']);

        }
    }



    public function EventDetails($event){
        try {
            $userFriends = Auth::user()->acceptedFriendsTo->merge(Auth::user()->acceptedFriendsFrom)->sortBy('friends.created_at');
            $friendsIds = array();
            foreach($userFriends as $friend){
                $friendsIds[] = $friend->id;
            }
            $event = Event::join('feed_results', 'events.id', 'feed_results.result_id')
            ->where('feed_results.type', 'events')
            ->where('feed_results.slug', $event)
            ->where(function($q) use($friendsIds){
                $q->where(function($q2) use($friendsIds){
                    $q2->where('feed_results.public', 0)
                    ->whereIn('feed_results.owner_id', $friendsIds);
                })
                ->orWhere('feed_results.public', 1)
                ->orWhere('feed_results.owner_id', Auth::user()->id);
                
            })
            ->select('events.*')
            ->firstOrFail();

            return view('places.event-details', ['event' => $event]);

        } catch (\Throwable $th) {
            return $th->getMessage();

        }
    }
}
