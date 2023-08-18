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


class FeedController extends Controller
{
    public static function index(){
        return view('feed.index');
    }

    public function ShowNewEvent(){
        return view('feed.new-event');
    }


    public static function SetLocation($venue){
        try {
            $location = Location::where('name', $venue)->get()->first();
            if(!$location){
                $location = Location::create([
                    'name' => $venue,
                    'locale' => App::currentLocale(),
                    'latitude' => 0,
                    'longitude' => 0,
                    'country_id' => 0,
                    'parent_location_id' => 0,
                ]);
            }

            return $location->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public static function SaveEvent(Request $req){
        try {
            $validator = Validator::make($req->all(), [
            
                'name' => 'required|string',
                'description' => 'required|string',
                'venue' => 'string',
                'category' => 'exists:categories,slug',
                'start_datetime' => 'date|date_format:Y-m-d\TH:i:s',
                'end_datetime' => 'date|date_format:Y-m-d\TH:i:s|after:start_datetime',
                'public' => 'boolean',
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }

            $category = Category::where('slug', $req->category)->firstOrFail();

            $location = null;
            if($req->venue){
                $location = FeedController::SetLocation($req->venue);
            }

            if($req->slug){
                $validator2 = Validator::make($req->all(), [
                    'slug' => 'exists:events,slug'
                ]);
                if($validator2->fails()){
                    throw ValidationException::withMessages([json_encode($validator2->errors())]);
                }
                
                $event = Event::where('slug', $req->slug)->where('owner_id', Auth::user()->id)->firstOrFail();

                $slug = $req->slug;
                $image_id = null;
                if($req->hasFile('event_image')){
                    $file = $req->file('event_image');
                    $filename = $slug.".".$req->file('event_image')->extension();
                    $file->storeAs('public/images/events',$filename);

                    $image = Image::create([
                        'file_name' => 'storage/images/events/'.$filename,
                        'visible' => true,
                        'owner_id' => Auth::user()->id,
                        'expiry_date' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $req->start_datetime)->addDays(1)
                    ]);
                    $image_id = $image->id;
                }
                
                
                $saveEvent = $event->update([
                    'name' => $req->name,
                    'description' => $req->description,
                    'start_datetime' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $req->start_datetime),
                    'end_datetime' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $req->end_datetime),
                    'public' => $req->public,
                    'category' => $category->id,
                    'location_id' => $location,
                    'image_id' => $image_id
                ]);

                return back()->with('success', __('main.messages.Event Saved Successfully'));

            }else{
                $slug = \Str::random(20);
                $username = "e".\Str::random(20);
                while(Event::where('slug', $slug)->get()->first()){
                    $slug = \Str::random(20);
                }
                
                $image_id = null;
                if($req->hasFile('event_image')){
                    $file = $req->file('event_image');
                    $filename = $slug.".".$req->file('event_image')->extension();
                    $file->storeAs('public/images/events',$filename);

                    $image = Image::create([
                        'file_name' => 'storage/images/events/'.$filename,
                        'visible' => true,
                        'owner_id' => Auth::user()->id,
                        'expiry_date' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $req->start_datetime)->addDays(1)
                    ]);
                    $image_id = $image->id;
                }


                $createEvent = Event::create([
                    'name' => $req->name,
                    'description' => $req->description,
                    'slug' => $slug,
                    'start_datetime' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $req->start_datetime),
                    'end_datetime' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $req->end_datetime),
                    'public' => $req->public,
                    'location_id' => $location,
                    'category_id' => $category->id,
                    'owner_id' => Auth::user()->id,
                    'image_id' => $image_id
                ]);

                
                $slug = \Str::random(20);
                while(FeedResult::where('slug', $slug)->get()->first()){
                    $slug = \Str::random(20);
                }
                $createEventResult = FeedResult::create([
                    'type' => 'events',
                    'result_id' => $createEvent->id,
                    'visible' => true,
                    'owner_id' => Auth::user()->id,
                    'public' => $req->public,
                    'slug' => $slug
                ]);

                return \Response::json([
                    'status' => 'success',
                    'message' => __('main.messages.Event Saved successfully')
                ], 200);
            }


        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function ShowNewThread(){
        return view('feed.new-thread');
    }

    public function SaveThread(Request $req){
        try {
            $validator = Validator::make($req->all(), [
            
                'title' => 'required|string',
                'content' => 'required|string',
                'public' => 'boolean',
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }

            if($req->slug){
                $validator2 = Validator::make($req->all(), [
                    'slug' => 'exists:threads,slug'
                ]);
                if($validator2->fails()){
                    throw ValidationException::withMessages([json_encode($validator2->errors())]);
                }
                
                $thread = Thread::where('slug', $req->slug)->where('owner_id', Auth::user()->id)->firstOrFail();

                $slug = $req->slug;
                $image_id = null;
                if($req->hasFile('thread_image')){
                    $file = $req->file('thread_image');
                    $filename = $slug.".".$req->file('thread_image')->extension();
                    $file->storeAs('public/images/threads',$filename);

                    $image = Image::create([
                        'file_name' => 'storage/images/threads/'.$filename,
                        'visible' => true,
                        'owner_id' => Auth::user()->id,
                        'expiry_date' => null
                    ]);
                    $image_id = $image->id;
                }
                
                
                $saveThread = $thread->update([
                    'title' => $req->title,
                    'content' => $req->content,
                    'public' => $req->public,
                ]);

                $thread->images()->attach($image_id);

                return \Response::json([
                    'status' => 'success',
                    'message' => __('main.messages.Thread Saved Successfully')
                ], 200);

            }else{
                $slug = \Str::random(20);
                $username = "e".\Str::random(20);
                while(Thread::where('slug', $slug)->get()->first()){
                    $slug = \Str::random(20);
                }
                
                $image_id = null;
                if($req->hasFile('thread_image')){
                    $file = $req->file('thread_image');
                    $filename = $slug.".".$req->file('thread_image')->extension();
                    $file->storeAs('public/images/threads',$filename);

                    $image = Image::create([
                        'file_name' => 'storage/images/threads/'.$filename,
                        'visible' => true,
                        'owner_id' => Auth::user()->id,
                        'expiry_date' => null
                    ]);
                    $image_id = $image->id;
                }


                $createThread = Thread::create([
                    'title' => $req->title,
                    'content' => $req->content,
                    'slug' => $slug,
                    'public' => $req->public,
                    'user_id' => Auth::user()->id,
                    'main_thread' => true
                ]);

                $slug = \Str::random(20);
                while(FeedResult::where('slug', $slug)->get()->first()){
                    $slug = \Str::random(20);
                }
                $createThreadResult = FeedResult::create([
                    'type' => 'threads',
                    'result_id' => $createThread->id,
                    'visible' => true,
                    'owner_id' => Auth::user()->id,
                    'public' => $req->public,
                    'slug' => $slug
                ]);

                $createThread->images()->attach($image_id);

                return \Response::json([
                    'status' => 'success',
                    'message' => __('main.messages.Thread Saved Successfully')
                ], 200);
            }


        } catch (\Throwable $th) {
            return \Response::json([
                    'status' => 'failure',
                    'message' => $th->getMessage()
                ], 200);
        }
    }



    public static function LoadFeed(Request $req){
        $userFriends = Auth::user()->acceptedFriendsTo->merge(Auth::user()->acceptedFriendsFrom)->sortBy('friends.created_at');
        $friendsIds = array();
        foreach($userFriends as $friend){
            $friendsIds[] = $friend->id;
        }
        $results = FeedResult::join('users', 'feed_results.owner_id', 'users.id')
        ->join('stays', 'users.id', 'stays.user_id')
        ->join('schools', 'stays.destination_school_id', 'schools.id')
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
        ->select('feed_results.*')
        ->orderBy('feed_results.created_at', 'DESC')
        ->get();


        return view('feed.feed_entries', ['results' => $results, 'category' => $req->category]);
        
    }


    public static function ShowUserFeed(Request $req){
        $user = User::where('unid', $req->user)->get()->first();
        if(!$user){
            return;
        }
        $userFriends = Auth::user()->acceptedFriendsTo->merge(Auth::user()->acceptedFriendsFrom)->sortBy('friends.created_at');
        $friendsIds = array();
        foreach($userFriends as $friend){
            $friendsIds[] = $friend->id;
        }
        $results = FeedResult::join('users', 'feed_results.owner_id', 'users.id')
        ->join('stays', 'users.id', 'stays.user_id')
        ->join('schools', 'stays.destination_school_id', 'schools.id')
        // ->where('feed_results.start_datetime', '>', \Carbon\Carbon::now())
        ->where('feed_results.owner_id', $user->id)
        ->where('feed_results.created_at', '>', \Carbon\Carbon::now()->subDays(300))
        ->where(function($q) use($friendsIds){
            $q->where(function($q2) use($friendsIds){
                $q2->where('public', 0)
                ->whereIn('owner_id', $friendsIds);
            })
            ->orWhere('public', 1);            
        })
        ->skip($req->skip)
        ->take(10)
        ->select('feed_results.*')
        ->orderBy('feed_results.created_at', 'DESC')
        ->get();


        return view('feed.feed_entries', ['results' => $results, 'category' => $req->category]);
        
    }


    public function ShowThread($thread_slug){
        try {
            $userFriends = Auth::user()->acceptedFriendsTo->merge(Auth::user()->acceptedFriendsFrom)->sortBy('friends.created_at');
            $friendsIds = array();
            foreach($userFriends as $friend){
                $friendsIds[] = $friend->id;
            }
            $thread = Thread::where('slug', $thread_slug)->firstOrFail();

            return view('feed.components.thread', ['thread' => $thread]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public function SaveThreadComment(Request $req){
        try {
            $validator = Validator::make($req->all(), [
            
                'content' => 'required|string',
                'thread' => 'required|exists:threads,slug',
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }

            //Check user's access to this thread.
            $userFriends = Auth::user()->acceptedFriendsTo->merge(Auth::user()->acceptedFriendsFrom)->sortBy('friends.created_at');
            $friendsIds = array();
            foreach($userFriends as $friend){
                $friendsIds[] = $friend->id;
            }
            $thread = Thread::where('slug', $req->thread)->where(function($q) use($friendsIds){
                $q->where(function($q2) use($friendsIds){
                    $q2->where('public', 0)
                    ->whereIn('owner_id', $friendsIds);
                })
                ->orWhere('public', 1)
                ->orWhere('owner_id', Auth::user()->id);
                
            })->firstOrFail();

            $slug = \Str::random(20);
            while(Thread::where('slug', $slug)->get()->first()){
                $slug = \Str::random(20);
            }

            $newThreadComment = Thread::create([
                'content' => $req->content,
                'public' => false,
                'main_thread' => false,
                'user_id' => Auth::user()->id,
                'parent_thread_id' => $thread->id,
                'slug' => $slug
            ]);


            return \Response::json([
                'status' => 'success',
                'message' => __('main.messages.Comment Saved successfully')
            ], 200);

        } catch (\Throwable $th) {
            return \Response::json([
                'status' => 'failure',
                'message' => $th->getMessage()
            ], 500);
        }
    }



    public function LikeAction(Request $req){
        try {
            $validator = Validator::make($req->all(), [
            
                'type' => 'required|in:events,threads',
                'slug' => 'required',
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }

            switch ($req->type) {
                case 'events':
                    $v2 = Validator::make($req->all(), [
            
                        'slug' => 'exists:events,slug',
                    ]);
        
                    if($v2->fails()){
                        throw ValidationException::withMessages([json_encode($validator->errors())]);
                    }
                    $result_type = 'events';
                    $result_id = Event::where('slug', $req->slug)->firstOrFail()->id;
                    break;
                case 'threads':
                    $v2 = Validator::make($req->all(), [
                        'slug' => 'exists:threads,slug',
                    ]);
                    if($v2->fails()){
                        throw ValidationException::withMessages([json_encode($validator->errors())]);
                    }
                    $result_type = 'threads';
                    $thread = Thread::where('slug', $req->slug)->firstOrFail();

                    $thread->likes = $thread->likes+1;
                    $thread->save();

                    $result_id = $thread->id;

                    break;
                
                default:
                    # code...
                    break;
            }


            $userAction = Action::updateOrCreate([
                'action' => 'like',
                'target_type' => $result_type,
                'target_id' => $result_id,
                'user_id' => Auth::user()->id
            ], []);
            




            return \Response::json([
                'status' => 'success',
                'message' => __('main.messages.You liked that')
            ], 200);
        } catch (\Throwable $th) {
            return \Response::json([
                'status' => 'failure',
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function SaveAction(Request $req){
        try {
            $validator = Validator::make($req->all(), [
            
                'type' => 'required|in:events,threads',
                'slug' => 'required',
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }

            switch ($req->type) {
                case 'events':
                    $v2 = Validator::make($req->all(), [
            
                        'slug' => 'exists:events,slug',
                    ]);
        
                    if($v2->fails()){
                        throw ValidationException::withMessages([json_encode($validator->errors())]);
                    }
                    $result_type = 'events';
                    $result_id = Event::where('slug', $req->slug)->firstOrFail()->id;
                    break;
                case 'threads':
                    $v2 = Validator::make($req->all(), [
                        'slug' => 'exists:threads,slug',
                    ]);
                    if($v2->fails()){
                        throw ValidationException::withMessages([json_encode($validator->errors())]);
                    }
                    $result_type = 'threads';
                    $thread = Thread::where('slug', $req->slug)->firstOrFail();

                    $thread->likes = $thread->likes+1;
                    $thread->save();

                    $result_id = $thread->id;

                    break;
                
                default:
                    # code...
                    break;
            }


            $userAction = Action::updateOrCreate([
                'action' => 'save',
                'target_type' => $result_type,
                'target_id' => $result_id,
                'user_id' => Auth::user()->id
            ], []);
            




            return \Response::json([
                'status' => 'success',
                'message' => __('main.messages.You saved that')
            ], 200);
        } catch (\Throwable $th) {
            return \Response::json([
                'status' => 'failure',
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function UnSaveAction(Request $req){
        try {
            $validator = Validator::make($req->all(), [
            
                'type' => 'required|in:events,threads',
                'slug' => 'required',
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }

            switch ($req->type) {
                case 'events':
                    $v2 = Validator::make($req->all(), [
            
                        'slug' => 'exists:events,slug',
                    ]);
        
                    if($v2->fails()){
                        throw ValidationException::withMessages([json_encode($validator->errors())]);
                    }
                    $result_type = 'events';
                    $result_id = Event::where('slug', $req->slug)->firstOrFail()->id;
                    break;
                case 'threads':
                    $v2 = Validator::make($req->all(), [
                        'slug' => 'exists:threads,slug',
                    ]);
                    if($v2->fails()){
                        throw ValidationException::withMessages([json_encode($validator->errors())]);
                    }
                    $result_type = 'threads';
                    $thread = Thread::where('slug', $req->slug)->firstOrFail();

                    $thread->likes = $thread->likes+1;
                    $thread->save();

                    $result_id = $thread->id;

                    break;
                
                default:
                    # code...
                    break;
            }


            $userAction = Action::where([
                'action' => 'save',
                'target_type' => $result_type,
                'target_id' => $result_id,
                'user_id' => Auth::user()->id
            ])->delete();
            




            return \Response::json([
                'status' => 'success',
                'message' => __('main.messages.Discarded')
            ], 200);
        } catch (\Throwable $th) {
            return \Response::json([
                'status' => 'failure',
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public static function DeleteResult(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'feed_result_slug' => 'required|exists:feed_results,slug'
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }

            $feed_result = FeedResult::where('slug', $req->feed_result_slug)->where('owner_id', Auth::user()->id)->firstOrFail();

            switch ($feed_result->type) {
                case 'events':
                    $feed_result->event->update([
                        'name' => '[DELETED CONTENT]',
                        'description' => '[DELETED CONTENT]',
                        'image_id' => null,
                        'location_id' => null,
                        'category_id' => null,
                        'start_datetime' => \Carbon\Carbon::now()->subDays(600),
                        'end_datetime' => \Carbon\Carbon::now()->subDays(599),
                    ]);
                    break;
                case 'threads':
                    $feed_result->thread->update([
                        'title' => '[DELETED CONTENT]',
                        'content' => '[DELETED CONTENT]',
                    ]);
                    $feed_result->thread->images()->update(['thread_id' => null]);
                    break;                
                default:
                    # code...
                    break;
            }

            return \Response::json([
                'status' => 'success',
                'message' => __('main.messages.Deleted Correctly')
            ], 200);
        } catch (\Throwable $th) {
            return \Response::json([
                'status' => 'failure',
                'message' => $th->getMessage()
            ], 500);        }
    }











    public static function SavedFeedPage(){
        return view('feed.saved.index');
    }



    public function ShowSavedFeed(Request $req){

        $results = Action::where('user_id', Auth::user()->id)
        ->select('*', 'user_id as owner_id', 'target_type as type', 'target_id as result_id')
        ->skip($req->skip)
        ->take(10)
        ->orderBy('actions.created_at', 'DESC')
        ->get();

        return view('feed.feed_entries', ['results' => $results, 'category' => $req->category]);
    }
}
