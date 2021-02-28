<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Server extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'servers';

    /**
     * @var data userId
     * 
     * @return array
     */
    
    public function servers(array $data = [])
    {
        $servers = DB::table($this->table);

        if(array_key_exists('userId',$data)) {
            $servers = $servers->where('owner',$data['userId']);
        }
        if(array_key_exists('favorite',$data)) {
            $servers = $servers->where('favorite','1');
        }
        if(array_key_exists('status',$data)) {
            $servers = $servers->where('enabled',$data['status']);
        }
        if(array_key_exists('users',$data)) {
            $servers = $servers->where('owner',$data['users']);
        }

        return $servers->get();
    }

    public function deleteServer($id,$userType)
    {
        $result = DB::table($this->table)->where('id',$id);
        if($userType != 'admin') $result = $result->where('owner',Auth()->id());
        return $result->delete();
    }

    public function isLink($serverId)
    {
        $result = DB::table($this->table)
            ->where('owner', Auth::id())
            ->where('id',$serverId)
            ->limit(1)
            ->get();

        if(count($result) == 1) return true;
        return false;
    }

}
