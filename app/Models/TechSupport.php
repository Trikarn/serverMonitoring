<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TechSupport extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'type',
        'status',
        'text',
        'author',
    ];

    protected $table = 'tech_support';

    public function supports(array $data = [])
    {
        $supports = DB::table($this->table);

        if(array_key_exists('userId',$data)) {
            $supports = $supports->where('author',$data['userId']);
        }
        if(array_key_exists('status',$data)) {
            $supports = $supports->where('status',$data['status']);
        }

        return $supports->get();
    }

    public function deleteTelegram($id,$userType)
    {
        $result = DB::table($this->table)->where('id',$id);
        if($userType != 'admin') $result = $result->where('owner',Auth()->id());
        return $result->delete();
    }

    public function isLink($supportId)
    {
        $result = DB::table($this->table)
            ->where('author', Auth::id())
            ->where('id',$supportId)
            ->limit(1)
            ->get();

        if(count($result) == 1) return true;
        return false;
    }

    public function changeStatus($id, $status)
    {
        $result = DB::table($this->table)
            ->where('id',$id)
            ->update([
                'status' => $status
            ]);

        return $result;
    }
}
