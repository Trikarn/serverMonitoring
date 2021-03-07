<?php

namespace App\Http\Controllers;

use App\Models\TechSupport;
use App\Models\TechSupportComments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function comments($id, TechSupportComments $supportComment)
    {
        $user = new User();

        $data = [
            'ticketId' => $id
        ];
        $comments = $supportComment->comments($data);

        foreach($comments as $comment){
            $comment->date = gmdate("d-m-Y H:i", $comment->date);
        }

        return $comments;
    }

    public function store($id, TechSupportComments $supportComment)
    {
        $data = request()->validate([
            'message' => ['required', 'string']
        ]);
        $data['author'] = Auth()->id();
        $data['date'] = time();
        $data['status'] = 'new';
        $data['ticket_id'] = $id;

        TechSupportComments::create($data);

        return redirect("/supports/$id/show")->with('status','Добавлен новый комментарий');
    }
}
