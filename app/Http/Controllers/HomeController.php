<?php

namespace App\Http\Controllers;

use App\User;
use App\Chat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function getUsers()
    {
        $users = User::where('id','!=',auth()->user()->id)->get();
        return response()->json($users, 200);
    }
    public function getMesseges($id)
    {
        $chats = Chat::where('sender',auth()->user()->id)
                     ->where('receiver',$id)
                     ->orWhere('receiver',auth()->user()->id)
                     ->where('sender',$id)
                     ->get();
        return response()->json($chats, 200);
    }
    public function storeChat(Request $request)
    {
        $chat = new Chat();
        $chat->sender = auth()->user()->id;
        $chat->receiver = $request->receiver;
        $chat->chat = $request->chat;
        $chat->save();
        return response()->json($chat, 200);
    }
}
