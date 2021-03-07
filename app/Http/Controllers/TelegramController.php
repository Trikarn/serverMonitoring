<?php

namespace App\Http\Controllers;

use App\Models\Telegram;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TelegramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('telegram.telegram');
    }

    public function create()
    {
        return view('telegram.add');
    }

    public function store(Request $request, User $user)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'chat' => ['required', 'integer'],
            'token' => ['required', 'string', 'max:255'],
            'owner' => ['required', 'integer'],
        ]);
        if(!$user->isAdmin()) $data['owner'] = Auth()->id();

        try {
            $sendToTelegram = fopen("https://api.telegram.org/bot".$data['token']."/sendMessage?chat_id=".$data['chat']."&text=Проверка бота", "r");
        } catch(Exception $e) {
            return back()->with('status','Введите корректные данные');
        }

        Telegram::create($data);

        return redirect('/telegram');
    }

    public function telegrams(Request $request)
    {
        $user = new User();
        $telegram = new Telegram();

        $data = [];
        if(!$user->isAdmin()) {
           $data['userId'] = Auth::id();
        }
        $telegrams = $telegram->telegrams($data);

        return $telegrams;
    }

    public function show()
    {

    }

    public function edit($id)
    {
        $user = new User();
        $telegram = new Telegram();

        if(!$user->isAdmin()) {
            $isLink = $telegram->isLink($id);
            if(!$isLink) return view('404');
        }
        $telegramData = Telegram::findOrFail($id);
        return view('telegram.manage',$telegramData);
    }

    public function update($id, User $user)
    {
        $user = new User();
        $telegram = new Telegram();

        if(!$user->isAdmin()) {
            $isLink = $telegram->isLink($id);
            if(!$isLink) return view('404');
        }
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'chat' => ['required', 'integer'],
            'token' => ['required', 'string', 'max:255'],
            'owner' => ['required', 'integer'],
        ]);

        try {
            $sendToTelegram = fopen("https://api.telegram.org/bot".$data['token']."/sendMessage?chat_id=".$data['chat']."&text=Проверка бота", "r");
        } catch(Exception $e) {
            return back()->with('status','Введите корректные данные');
        }

        if(!$user->isAdmin()) $data['owner'] = Auth()->id();
        Telegram::where('id',$id)->update($data);

        return redirect('/telegram');
    }

    public function destroy($id, Telegram $telegram)
    {
        $user = new User();
        $telegram = new Telegram();

        if(!$user->isAdmin()) {
            $isLink = $telegram->isLink($id);
            if(!$isLink) return view('404');
        }
        $userType = Auth()->user()->type;
        
        $result = $telegram->deleteTelegram($id,$userType);

        return [
            'success' => 'true'
        ];
    }

}
