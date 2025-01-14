<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class A extends Controller
{
    public function list() {
        $response = Http::get('http://apisite/api/list');
        // Yanıtı kontrol edin
        if ($response->successful()) {
            return $response->json(); // Veriyi döndür
        }
        else {
            return ['error' => 'Failed to fetch data'];
        }

    }
}
