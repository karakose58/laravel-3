<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AA extends Controller
{
    public function registerPage()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $apiUrl = 'http://apisite/api/register';
        $response = Http::post($apiUrl, [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            return redirect()->route('login.page')->with('message', 'Kayıt başarılı! Lütfen giriş yapınız.');
        }

        return back()->withErrors(['register' => 'Kayıt işlemi başarısız oldu.']);
    }

    public function loginPage()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $response = Http::post('http://apisite/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            session(['auth_token' => $data['access_token']]);
            return redirect()->route('home')->with('message', 'Başarıyla giriş yapıldı!');
        }

        return back()->withErrors(['login' => 'Giriş başarısız.']);
    }

    public function home()
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get('http://apisite/api/products');

        $products = [];
        if ($response->successful()) {
            $products = $response->json();
        }

        return view('anasayfa', compact('products'));
    }

    public function logout()
    {
        $response = Http::withToken(session('auth_token'))->post('http://apisite/api/logout');

        if ($response->successful()) {
            session()->forget('auth_token');
            return redirect()->route('login.page')->with('message', 'Başarıyla çıkış yaptınız.');
        }

        return back()->withErrors(['logout' => 'Çıkış işlemi başarısız oldu.']);
    }

    public function add()
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Ürün eklemek için giriş yapmalısınız.');
        }
        return view('ekle');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'string|max:255',
        ]);

        $response = Http::withToken(session('auth_token'))->post('http://apisite/api/add', [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        if ($response->successful()) {
            return redirect()->route('home')->with('message', 'Ürün başarıyla eklendi!');
        }

        return back()->withErrors(['add_product' => 'Ürün ekleme işlemi başarısız oldu.']);
    }

    public function edit($id)
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Ürün düzenlemek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get("http://apisite/api/products/{$id}");

        if ($response->successful()) {
            $product = $response->json();
            return view('edit', compact('product'));
        }

        return back()->withErrors(['edit_product' => 'Ürün düzenleme işlemi başarısız oldu.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'string|max:255',
        ]);

        $response = Http::withToken(session('auth_token'))->put("http://apisite/api/update/{$id}", [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        if ($response->successful()) {
            return redirect()->route('home')->with('message', 'Ürün başarıyla güncellendi!');
        }

        return back()->withErrors(['update_product' => 'Ürün güncelleme işlemi başarısız oldu.']);
    }

    public function delete($id)
    {
        $response = Http::withToken(session('auth_token'))->delete("http://apisite/api/delete/{$id}");

        if ($response->successful()) {
            return redirect()->route('home')->with('message', 'Ürün başarıyla silindi.');
        }

        return back()->withErrors(['delete_product' => 'Ürün silinemedi.']);
    }

    public function show($id)
{
    if (!session()->has('auth_token')) {
        return redirect()->route('login.page')->with('error', 'Ürünü görüntülemek için giriş yapmalısınız.');
    }

    $response = Http::withToken(session('auth_token'))->get("http://apisite/api/products/{$id}");

    if ($response->successful()) {
        $product = $response->json();
        return view('show', compact('product'));
    }

    return back()->withErrors(['error' => 'Ürün bulunamadı veya API isteği başarısız oldu.']);
}

}
