<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PlacesController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['prefix' => LaravelLocalization::setLocale(), 	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function()
{
	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
	Route::middleware(['auth'])->get('/old', function () {
        return view('layouts.main');
    });

    Route::middleware(['auth'])->get('/', function () {
        return view('layouts.main2');
    });

    Route::get('/logout', function () {
        Auth::logout();
     
        return redirect('/');
    })->name('logout');

    Route::group(['prefix' => 'auth', 'middleware' => ['guest']], function(){
        Route::get('/login', function () {
            return view('auth.login');
        })->name('login');

        Route::post('/login', [AuthController::class, 'LogIn']);
        Route::post('/test-login', [AuthController::class, 'TestLogIn']);
    });


    Route::group(['prefix' => 'me', 'middleware' => ['auth']], function(){
        Route::get('/', [UserController::class, 'ShowMyProfile']);
        Route::get('/stay', [UserController::class, 'ShowMyStay']);
        Route::get('/edit-profile', function () {
            return view('user.edit-profile');
        });

        Route::group(['prefix' => 'update'], function(){
            Route::post('userDetails', [UserController::class, 'UpdateUserDetails']);
            Route::post('stay', [UserController::class, 'UpdateStayDetails']);
        });
    });

    Route::group(['prefix' => 'user', 'middleware' => ['auth']], function(){
        Route::get('/feed', [FeedController::class, 'ShowUserFeed']);
        Route::post('/request-friendship', [UserController::class, 'RequestFriendship']);
        Route::post('/revoke-friendship', [UserController::class, 'RevokeFriendship']);
        Route::post('/accept-friendship', [UserController::class, 'AcceptFriendship']);
        Route::get('/{unid}', [UserController::class, 'ShowUserProfile']);


        Route::get('/{unid}/friends', [UserController::class, 'UserFriends']);
    });



    Route::group(['prefix' => 'feed', 'middleware' => ['auth']], function(){
        Route::get('/', [FeedController::class, 'index']);
        Route::get('/new-event', [FeedController::class, 'ShowNewEvent']);
        Route::post('/save-new-event', [FeedController::class, 'SaveEvent']);


        Route::get('/new-thread', [FeedController::class, 'ShowNewThread']);
        Route::get('/thread/{id}', [FeedController::class, 'ShowThread']);
        Route::post('/save-new-thread', [FeedController::class, 'SaveThread']);
        Route::post('save-thread-comment', [FeedController::class, 'SaveThreadComment']);


        Route::post('like', [FeedController::class, 'LikeAction']);
        Route::post('delete-result', [FeedController::class, 'DeleteResult']);
        Route::post('save', [FeedController::class, 'SaveAction']);
        Route::post('unsave', [FeedController::class, 'UnSaveAction']);


        Route::get('feed', [FeedController::class, 'LoadFeed']);


        Route::get('saved', [FeedController::class, 'SavedFeedPage']);
        Route::get('saved/feed', [FeedController::class, 'ShowSavedFeed']);
    });


    Route::group(['prefix' => 'places', 'middleware' => ['auth']], function(){
        Route::get('index', [PlacesController::class, 'index']);

        Route::get('load-events', [PlacesController::class, 'FindEvents']);
        Route::get('event-card', [PlacesController::class, 'ShowEvent']);
        Route::get('event/{event_slug}', [PlacesController::class, 'EventDetails']);
    });


    
    
});
