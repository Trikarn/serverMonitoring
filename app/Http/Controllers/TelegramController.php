<?php

namespace App\Http\Controllers;

use App\Models\Telegram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TelegramController extends Controller
{
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
        $telegramData = Telegram::findOrFail($id);
        return view('telegram.manage',$telegramData);
    }

    public function update($id, User $user)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'chat' => ['required', 'integer'],
            'token' => ['required', 'string', 'max:255'],
            'owner' => ['required', 'integer'],
        ]);

        if(!$user->isAdmin()) $data['owner'] = Auth()->id();
        Telegram::where('id',$id)->update($data);

        return redirect('/telegram');
    }

    public function destroy($id, Telegram $telegram)
    {
        $userType = Auth()->user()->type;
        
        $result = $telegram->deleteTelegram($id,$userType);

        return [
            'success' => 'true'
        ];
    }

}
