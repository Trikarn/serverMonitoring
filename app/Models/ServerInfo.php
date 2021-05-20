<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServerInfo extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'date',
    //     'type',
    //     'status',
    //     'text',
    //     'author',
    // ];

    protected $table = 'server_info';

    /**
     * @var data serverId, enabled, dateFrom, dateTo, sort
     */
    public function information(array $data = [])
    {
        $info = DB::table($this->table)
            ->leftjoin('servers',"$this->table.server",'servers.id')
            ->select('server_info.*');
            

        if(array_key_exists('serverId',$data)) {
            $info = $info->where('server',$data['serverId']);
        }
        if(array_key_exists('enabled',$data)) {
            $info = $info->where("$this->table.enabled",$data['enabled']);
        }
        if(array_key_exists('dateFrom',$data)) {
            $info = $info->where('time','>=',$data['dateFrom']);
        }
        if(array_key_exists('dateTo',$data)) {
            $info = $info->where('time','<=',$data['dateTo']);
        }
        if(array_key_exists('sort',$data)) {
            $info = $info->orderBy('server_info.' . $data['sort'], 'desc');
        } else {
            $info = $info->orderBy('server_info.id', 'desc');
        }
        if(array_key_exists('limit',$data)) {
            $info = $info->limit($data['limit']);
        }
        if(array_key_exists('offset',$data)) {
            $info = $info->offset($data['offset']);
        }
        if(array_key_exists('count',$data)) {
            return $info->count();
        }

        return $info->get();
    }

    /**
     * @var data infoId, lastInfo, serverId, tempProc, tempHDD, status, dateTo, dateFrom, sort
     */
    public function get(array $data = [])
    {
        $info = DB::table($this->table)
            ->join('servers',"$this->table.server",'servers.id')
            ->select("$this->table.*");

        if(array_key_exists('infoId',$data)) {
            $info = $info->where("$this->table.id",$data['infoId']);
        }
        if(array_key_exists('lastInfo',$data)) {
            $info = $info->orderBy('time','desc');
        }
        if(array_key_exists('serverId',$data)) {
            $info = $info->where('server',$data['serverId']);
        }
        if(array_key_exists('tempProc',$data)) {
            $info = $info->where('temp_proces','>=',$data['tempProc']);
        }
        if(array_key_exists('tempHDD',$data)) {
            $info = $info->where('temp_hard','>=',$data['tempHDD']);
        }
        if(array_key_exists('status',$data)) {
            $info = $info->where("$this->table.enabled",$data['status']);
        }
        if(array_key_exists('dateFrom',$data)) {
            $info = $info->where('time','>=',$data['dateTo']);
        }
        if(array_key_exists('dateTo',$data)) {
            $info = $info->where('time','<=',$data['dateTo']);
        }
        if(array_key_exists('sort',$data)) {
            $info = $info->orderBy($data['sort'], 'asc');
        }


        $info = $info
            ->limit(1)
            ->get();

        if(count($info) == 1) return $info[0];
        return [];
    }

    public function add($data)
    {
        $result = DB::table($this->table)
            ->insert($data);

        return true;
    }

    public function isLink($idInfo) {
        $result = DB::table($this->table)
            ->where('id',$idInfo)
            ->limit(1)
            ->get();

        if(count($result) != 1) return false;

        $isLink = DB::table('servers')
            ->where('id',$result[0]->server)
            ->where('owner',Auth::id())
            ->limit(1)
            ->get();

        if(count($isLink) == 1) return true;
        return false;
    }
}
