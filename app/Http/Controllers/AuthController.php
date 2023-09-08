<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

use Stevebauman\Location\Facades\Location;

class AuthController extends Controller
{
    use HasApiTokens;
    //
    public function signup(Request $request)
    {
        //
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required| min:8',

        ]);


        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        // if ($currentUser->user_level !== 2 && $currentUser->user_level !== 3) {
        //     return response()->json(['error' => 'only admin and host can add new user.'], 301);
        // }

    

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // $admin->sendEmailVerificationNotification();

        $ipAddress = $request->header('X-Forwarded-For');
        $userInfo = Location::get($ipAddress);
    
        
        $user->locations()->create([
            'ip_address' => $ipAddress,
            'country' => $userInfo->countryName,
            'city' => $userInfo->cityName,
            'latitude' => $userInfo->latitude,
            'longitude' => $userInfo->longitude,
            'action' => 'register'
        ]);

        return response()->json([
            'success' => 'User register successful',
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        if(Auth::attempt([ 'email' => $request->input('email'),'password' => $request->input('password')])) {
            



            $user = User::where('email', '=', $request->input('email'))->firstOrFail();

            
            $token = $user->createToken('api-token')->plainTextToken;
            
          
            $ipAddress = $request->header('X-Forwarded-For');
            $userInfo = Location::get($ipAddress);
        
            
            $user->locations()->create([
                'ip_address' => $ipAddress,
                'country' => $userInfo->countryName,
                'city' => $userInfo->cityName,
                'latitude' => $userInfo->latitude,
                'longitude' => $userInfo->longitude,
                'action' => 'login'
            ]);

            return response()->json([
                'token' => $token,
                'user_id' => $user->id,
                'success' => 'Login Successful.'
            ], 200);

        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        
    }


    public function logout(Request $request) {
        
        $user = $request->user();
        $user->tokens()->delete();

        $ipAddress = $request->header('X-Forwarded-For');
        $userInfo = Location::get($ipAddress);
    
        
        $user->locations()->create([
            'ip_address' => $ipAddress,
            'country' => $userInfo->countryName,
            'city' => $userInfo->cityName,
            'latitude' => $userInfo->latitude,
            'longitude' => $userInfo->longitude,
            'action' => 'logout',
        ]);

        return response()->json(['success' => 'Logout successful'], 200);
    }

}
