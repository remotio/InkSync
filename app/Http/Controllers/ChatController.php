<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Http;

//デバッグ用
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function sendChat(Request $request)
    {
        $message = $request->input('message');
        $response = Gemini::geminiPro()->generateContent($message);
        return response()->json([
            'message' => $response->text(),
        ]);
    }
}
