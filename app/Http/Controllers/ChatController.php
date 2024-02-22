<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ChatRepository;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $chatRepository;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function index()
    {
        $chats = $this->chatRepository->getAllChats();
        return response()->json($chats);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'receiver_id' => 'required',
            'message' => 'required',
        ]);
        
        $validatedData['sender_id'] = Auth::id();

        $chat = $this->chatRepository->create($validatedData);

        broadcast(new MessageSent($chat));

        return response()->json($chat, 201);
    }
}
