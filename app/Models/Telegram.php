<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Telegram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'chat',
        'token',
        'owner'
    ];

    protected $table = 'telegram';

    public function telegrams(array $data = [])
    {
        $telegrams = DB::table($this->table);

        if(array_key_exists('userId',$data)) {
            $telegrams = $telegrams->where('owner',$data['userId']);
        }

        return $telegrams->get();
    }

    public function deleteTelegram($id,$userType)
    {
        $result = DB::table($this->table)->where('id',$id);
        if($userType != 'admin') $result = $result->where('owner',Auth()->id());
        return $result->delete();
    }

    public function isLink($telegramId)
    {
        $result = DB::table($this->table)
            ->where('owner', Auth::id())
            ->where('id',$telegramId)
            ->limit(1)
            ->get();

        if(count($result) == 1) return true;
        return false;
    }
}
