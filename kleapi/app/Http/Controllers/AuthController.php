<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    public function logout(Request $request)
    {
        
        $request->user()->currentAccessToken()->delete();
    
        return response()->json([
            'message' => 'Başarıyla çıkış yaptınız.'
        ]);
    }
    
    
        public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
        
            $user = User::where('email', $request->email)->first();
            
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Giriş bilgileri hatalı. E-posta adresinizi yada şifrenizi kontrol edin.'
                ], 401);
            }
        
            $token = $user->createToken('auth_token')->plainTextToken;
        
            return response()->json([
                'message' => 'Giriş başarılı!',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
    
        public function register(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('viewer');


            
    
    
            return response()->json([
                'message' => 'Kayıt başarılı!',

            ]);
        }
}
