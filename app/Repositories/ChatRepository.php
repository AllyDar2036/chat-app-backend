<?php

namespace App\Repositories;

use App\Models\Chat;

class ChatRepository
{
    public function create(array $data)
    {
        return Chat::create($data);
    }

    public function getAllChats()
    {
        return Chat::latest()->get();
    }

    // You can add more methods here as needed, such as getting chats for a specific user, etc.
}
