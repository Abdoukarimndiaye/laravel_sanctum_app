<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use Illuminate\Support\Facades\Hash;
 

class AuthController extends Controller
{
    public function register(Request $request){
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
          ]);

          $user = User::create([
              'name' => $validatedData['name'],
              'email' => $validatedData['email'],
              'password' => Hash::make($validatedData['password']),
          ]);
          return response()->json([
              'name' => $user->name,
              'email' => $user->email,
          ]);   
    }
    public function login(Request $request){
        $user = User::where('email',$request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) 
        {
              return response()->json([
                  'message' => ['votre email ou nom est incorrecte'],
              ]);
          }
          $user->tokens()->delete();

          return response()->json([
              'status' => 'success',
              'message' => 'vous etes connectés',
              'name' => $user->name,
              'token' => $user->createToken('auth_token')->plainTextToken,
          ]);
    }
    public function logout(Request $request){
       $request->user()->currentAccessToken()->delete();
                return response()->json(
                   [
                       'status' => 'success',
                        'message' => 'vous etes deconnecté'
                   ]);
  }

}
