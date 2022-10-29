<?php

namespace App\Http\Controllers;

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
    public function BotTele($text)
    {
        $token = "5075128840:AAHiSMiaklroexl8EL96y_WVc5-e7WAqkA4";
        $chat_id = "5074592898";
        $data = [
            "text" => $text,
            "chat_id" => $chat_id,
        ];
        file_get_contents("https://api.telegram.org/bot" . $token . "/sendMessage?" . http_build_query($data));
    }

    public function index()
    {
        return view('home');
    }
}
