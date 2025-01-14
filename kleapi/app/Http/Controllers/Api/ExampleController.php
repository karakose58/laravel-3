<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ExampleController extends Controller
{
    public function logout(Request $request)
{
    // Şu anda kullanılan token'ı sil
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

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Kayıt başarılı!',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function listProducts()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function getProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Ürün bulunamadı. Geçerli bir ürün ID\'si girin.'
            ], 404);
        }

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'required|string|max:255',
        ]);

        $user = auth()->user(); // Doğrulanmış kullanıcı bilgisi

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return response()->json($product, 201);
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Ürün başarıyla silindi']);
        }

        return response()->json([
            'message' => 'Silinmek istenen ürün bulunamadı. ID kontrol edin.'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'required|string|max:255',
        ]);

        $product = Product::find($id);

        if ($product) {
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
            ]);

            return response()->json(['message' => 'Ürün başarıyla güncellendi', 'product' => $product]);
        }

        return response()->json([
            'message' => 'Güncellenecek ürün bulunamadı. Lütfen geçerli bir ürün ID\'si girin.'
        ], 404);
    }
}
