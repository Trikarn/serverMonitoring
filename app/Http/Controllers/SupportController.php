<?php

namespace App\Http\Controllers;

use App\Models\TechSupport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
    {
        return view('support.supports');
    }

    public function create()
    {
        return view('support.add');
    }

    public function store(Request $request, User $user)
    {
        $data = request()->validate([
            'type' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string', 'max:255']
        ]);
        $data['author'] = Auth()->id();
        $data['date'] = time();
        $data['status'] = 'new';

        TechSupport::create($data);

        return redirect('/supports');
    }

    public function supports(Request $request)
    {
        $user = new User();
        $techSupport = new TechSupport();

        $data = [];
        if(!$user->isAdmin()) {
           $data['userId'] = Auth::id();
        }
        $techSupports = $techSupport->supports($data);

        $techSupports = $this->parserToUserFriendly($techSupports);

        return $techSupports;
    }

    public function show($id, TechSupport $techSupport)
    {
        $supportData = TechSupport::findOrFail($id);
        return view('support.show',$supportData);
    }

    // public function edit($id)
    // {
    //     $telegramData = Telegram::findOrFail($id);
    //     return view('telegram.manage',$telegramData);
    // }

    // public function update($id, User $user)
    // {
    //     $data = request()->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'chat' => ['required', 'integer'],
    //         'token' => ['required', 'string', 'max:255'],
    //         'owner' => ['required', 'integer'],
    //     ]);

    //     if(!$user->isAdmin()) $data['owner'] = Auth()->id();
    //     Telegram::where('id',$id)->update($data);

    //     return redirect('/telegram');
    // }

    // public function destroy($id, TechSupport $techSupport)
    // {
    //     $userType = Auth()->user()->type;
        
    //     $result = $techSupport->deleteSu($id,$userType);

    //     return [
    //         'success' => 'true'
    //     ];
    // }

    /**
     * @var supports date, type, status
     */
    public function parserToUserFriendly($supports)
    {
        $types = [
            'general_issues' => 'Общие вопросы',
            'wishes' => 'Пожелания',
            'errors' => 'Ошибки',
            'other' => 'Другое'
        ];
        $statuses = [
            'new' => 'Новый',
            'work' => 'В работе',
            'closed' => 'Закрыто'
        ];

        foreach($supports as $support) {
            $support->date = gmdate("d-m-Y", $support->date);
            $support->type = $types[$support->type];
            $support->status = $statuses[$support->status];
        }

        return $supports;
    }



}
