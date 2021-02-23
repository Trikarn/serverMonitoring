<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TechSupportComments extends Model
{
    use HasFactory;

    protected $table = 'tech_support_comments';

    protected $fillable = [
        'ticket_id',
        'author',
        'message',
        'date'
    ];

    public function comments(array $data = [])
    {
        $comments = DB::table($this->table)
            ->join('users',"$this->table.author",'users.id')
            ->select("$this->table.*",'users.username')
            ->orderBy('date','asc');

        if(array_key_exists('ticketId',$data)) {
            $comments = $comments->where('ticket_id',$data['ticketId']);
        }

        return $comments->get();
    }
}
