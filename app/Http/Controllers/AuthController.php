<?php

namespace App\Http\Controllers;

use \Google_Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Storage;
use App\Models\Image;
use App\Models\User;
use Auth;
use \Imagick;
use Illuminate\Support\Str;


class AuthController extends Controller
{

    public static function UploadUserImage($imageUrl, $storagePath, $user_id){
    
        $imageContent = file_get_contents($imageUrl);
        $tempImage = imagecreatefromstring($imageContent);
        $webpImage = imagecreatefromstring($imageContent);
        ob_start();
        imagewebp($webpImage, null, 80);
        $webpData = ob_get_contents();
        ob_end_clean();

        // Free up memory
        imagedestroy($webpImage);
        imagedestroy($tempImage);

        // Store the WebP image in the specified storage location with the custom name
        Storage::put("public/images/{$storagePath}/u_{$user_id}.webp", $webpData);

        $image = Image::updateOrCreate(['owner_id' => $user_id, 'file_name' => 'storage/images/'.$storagePath.'/u_'.$user_id.'.webp']);

        return $image->id;

    }

    public function LogIn(Request $req){
        try {
            // $validator = Validator::make($req->all(), [
            //     ''
            // ]);
            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);  // Specify the CLIENT_ID of the app that accesses the backend
            $payload = $client->verifyIdToken($req->credential);
            if ($payload) {
            $email = $payload['email'];
            // return $payload;
            $user = User::where('email', $email)->get();
            if ($user->first()) {
                Auth::login($user->first());
            }else{
                $unid = Str::random(20);
                $username = "user_".Str::random(20);
                while(User::where('unid', $unid)->get()->first()){
                    $unid = Str::random(20);
                }
                while(User::where('username', $username)->get()->first()){
                    $username = "user_".Str::random(20);
                }
                $user = User::create([
                    'email' => $payload['email'],
                    'name' => $payload['given_name'],
                    'unid' => $unid,
                    'password' => 'u-auth',
                    'username' => $username
                ]);

                $userImageId = AuthController::UploadUserImage($payload['picture'], 'u/profile_pictures', $user->id);

                $user->update([
                    'profile_img' => $userImageId
                ]);

                Auth::login($user);

                return "logged_in";

            }

                return response()->json(['user' => $userid]);
            } else {
            // Invalid ID token
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
    }

    public function TestLogIn(){
        $user = User::where('email', 'johnny.leon.20.02@gmail.com')->first();
        Auth::login($user);
        return redirect('/');
    }
}
