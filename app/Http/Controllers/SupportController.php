<?php

namespace App\Http\Controllers;

use App\Models\TechSupport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
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

        return redirect('/supports')->with('status','Успешно');
    }

    public function supports(Request $request)
    {
        $user = new User();
        $techSupport = new TechSupport();

        $data = [];
        $status = $request->input('status');
        
        if(!$user->isAdmin()) {
           $data['userId'] = Auth::id();
        }
        if(!empty($status)) $data['status'] = $status;

        $techSupports = $techSupport->supports($data);

        $techSupports = $this->parserToUserFriendly($techSupports);

        return $techSupports;
    }

    public function show($id, TechSupport $techSupport)
    {
        $user = new User();

        if(!$user->isAdmin()) {
            $isLink = $techSupport->isLink($id);
            if(!$isLink) return view('404');
        }
        $supportData = TechSupport::findOrFail($id);
        $userData = User::find($supportData->author);
        $supportData->author = $userData->username;
        
        return view('support.show',$supportData);
    }


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

    public function changeStatus($id, Request $request)
    {
        $user = new User();
        $techSupport = new TechSupport();

        $status = $request->input('status');
        if(empty($status)) return;

        if(!$user->isAdmin()) {
            $isLink = $techSupport->isLink($id);
            if(!$isLink) return view('404');
        }

        $techSupport->changeStatus($id, $status);

        return back()->with('status','Успешно');
    }



}
