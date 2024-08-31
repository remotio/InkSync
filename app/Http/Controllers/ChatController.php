<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Chat;

//デバッグ用
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function sendChat(Request $request)
    {
        \Log::info('user input', ['variable' => $request]);
        $message = $request->input('message');
        Chat::create([
            'work_id'=>$request->input('work_id'),
            'is_user'=>1,
            'message'=>$message,
        ]);
        
        $response = Gemini::geminiPro()->generateContent($message);
        $geminiMessage=$response->text();
        Chat::create([
            'work_id'=>$request->input('work_id'),
            'is_user'=>0,
            'message'=>$geminiMessage,
        ]);
    
        
        return response()->json([
            'message' => $geminiMessage,
        ]);
    }

    public function getHistory (Request $request) {
        $workId = $request->input('work_id');
        $history = Chat::where('work_id', $workId)->orderBy('created_at')->get();
    
        return response()->json(['history' => $history]);
    }
}
