<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\User;
use App\Models\Stay;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

use App\Models\School;


class UserController extends Controller
{
    public function UpdateUserDetails(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'name' => 'required|string',
                'username' => 'required|string|unique:users,username,'.Auth::user()->id,
                'destination' => 'in:es,en,fr',
                'locale' => 'required|in:es,en,fr'
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }
            

            Auth::user()->update([
                'name' => $req->name,
                'username' => $req->username,
                'locale' => $req->locale
            ]);

            return \Response::json([
                'message' => __('main.messages.Changes Saved successfully')
            ], 200); // Status code here
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }



    public function UserFriends($user){
        try {
            $user = User::where('unid', $user)->firstOrFail();
            $friends = Auth::user()->acceptedFriendsTo->merge(Auth::user()->acceptedFriendsFrom)->sortBy('friends.created_at');
            return view('user.users-list', ['users' => $friends]);

        } catch (\Throwable $th) {
            return __('main.messages.Error while fetching data');
        }
    }

    public static function ShowMyProfile(){
        return UserController::ShowUserProfile(Auth::user()->unid);
    }

    public static function ShowUserProfile($user){
        try {
            $user = User::where('unid', $user)->firstOrFail();
            return view('user.index', ['user' => $user]);

        } catch (\Throwable $th) {
            return __('main.messages.Error while fetching data');
        }
    }


    public function ShowMyStay(){
        try {
            $stay = Auth::user()->stay;
            return view('user.stay', ['stay' => $stay]);
        } catch (\Throwable $th) {
            return __('main.messages.Error while fetching data');
        }
    }


    public function UpdateStayDetails(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'home_country' => 'required|string|exists:countries,slug',
                'home_school' => 'required|string|exists:schools,slug',
                'destination_country' => 'required|string|exists:countries,slug',
                'destination_school' => 'required|string|exists:schools,slug',
                'start_datetime' => 'required|date|date_format:Y-m-d',
                'end_datetime' => 'required|date|after:start_datetime|date_format:Y-m-d',
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }



            $newStay = Stay::updateOrCreate([
                'user_id' => Auth::user()->id
            ], [
                'origin_country_id' => Country::where('slug', $req->home_country)->firstOrFail()->id,
                'destination_country_id' => Country::where('slug', $req->destination_country)->firstOrFail()->id,
                'origin_school_id' => School::where('slug', $req->home_school)->firstOrFail()->id,
                'destination_school_id' => School::where('slug', $req->destination_school)->firstOrFail()->id,
                'start_datetime' => $req->start_datetime,
                'end_datetime' => $req->end_datetime,
            ]);

            if($newStay){
                return \Response::json([
                    'message' => __('main.messages.Changes Saved successfully')
                ], 200);
            }else{
                throw ValidationException::withMessages([json_encode([__('main.messages.Error while fetching data')])]);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }




    public function RequestFriendship(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'unid' => 'required|exists:users,unid',
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }


            $user = User::where('unid', $req->unid)->firstOrFail();

            if(Auth::user()->id != $user->id && Auth::user()->acceptedFriendsFrom()->where('user_id', $user->id)->count() == 0 && $user->acceptedFriendsFrom()->where('user_id', Auth::user()->id)->count() == 0){
                DB::table('friends')->updateOrInsert([
                    'user_id' => Auth::user()->id,
                    'friend_id' => $user->id,
                    'accepted' => false
                ], []);
            }


            return \Response::json([
                'status' => 'success',
                'message' => __('main.messages.Friendship request Sent')
            ], 200);
        } catch (\Throwable $th) {
            return \Response::json([
                'status' => 'failure',
                'message' => $th->getMessage()
            ], 200);
        }
    }


    public function AcceptFriendship(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'unid' => 'required|exists:users,unid',
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }


            $user = User::where('unid', $req->unid)->firstOrFail();

            if(Auth::user()->id != $user->id && Auth::user()->acceptedFriendsFrom()->where('user_id', $user->id)->count() == 0 && $user->acceptedFriendsFrom()->where('user_id', Auth::user()->id)->count() == 0){
                DB::table('friends')->where('user_id', $user->id)
                ->where('friend_id', Auth::user()->id)->update([
                    'accepted' => true
                ]);
            }


            return \Response::json([
                'status' => 'success',
                'message' => __('main.messages.Friendship Request Accepted')
            ], 200);
        } catch (\Throwable $th) {
            return \Response::json([
                'status' => 'failure',
                'message' => $th->getMessage()
            ], 200);
        }
    }



    public function RevokeFriendship(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'unid' => 'required|exists:users,unid',
            ]);

            if($validator->fails()){
                throw ValidationException::withMessages([json_encode($validator->errors())]);
            }
            $user = User::where('unid', $req->unid)->firstOrFail();

                DB::table('friends')->where('user_id', Auth::user()->id)
                ->where('friend_id', $user->id)->delete();
                DB::table('friends')->where('friend_id', Auth::user()->id)
                ->where('user_id', $user->id)->delete();


            return \Response::json([
                'status' => 'success',
                'message' => __('main.messages.Friendship revoked')
            ], 200);
        } catch (\Throwable $th) {
            return \Response::json([
                'status' => 'failure',
                'message' => $th->getMessage()
            ], 200);
        }
    }
}
