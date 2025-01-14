<?php

namespace App\Http\Controllers;

use App\Models\Post; 
use Illuminate\Http\Request; 
class PostController extends Controller
{
    public function listProducts()
    {
        $post = Post::all();
        return response()->json($post);
    }

    public function getProduct($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Ürün bulunamadı. Geçerli bir ürün ID\'si girin.'
            ], 404);
        }

        return response()->json($post);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string|max:255',
        ]);
    
        $post = Post::create([
            'title' => $request->title,
            'text' => $request->text,
            'user_id' => auth()->id(),
        ]);
    
        return response()->json(['message' => 'Yazı başarıyla oluşturuldu', 'post' => $post], 201);
    }
    

    public function delete($id)
    {
        $post = Post::findOrFail($id);
    
        if ($post->user_id != auth()->id()) {
            return response()->json(['message' => 'Bu yazıyı silme yetkiniz yok.'], 403);
        }
    
        $post->delete();
        return response()->json(['message' => 'Yazı başarıyla silindi']);
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string|max:255',
        ]);
    
        $post = Post::findOrFail($id);
    
        if ($post->user_id != auth()->id()) {
            return response()->json(['message' => 'Bu yazıyı düzenleme yetkiniz yok.'], 403);
        }
    
        $post->update([
            'title' => $request->title,
            'text' => $request->text,
        ]);
    
        return response()->json(['message' => 'Yazı başarıyla güncellendi', 'post' => $post]);
    }
    
}
