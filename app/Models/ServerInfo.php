<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
            ->join('servers',"$this->table.server",'servers.id');

        if(array_key_exists('serverId',$data)) {
            $info = $info->where('server',$data['serverId']);
        }
        if(array_key_exists('enabled',$data)) {
            $info = $info->where('enabled',$data['enabled']);
        }
        if(array_key_exists('dateFrom',$data)) {
            $info = $info->where('time','>=',$data['dateFrom']);
        }
        if(array_key_exists('dateTo',$data)) {
            $info = $info->where('time','<=',$data['dateTo']);
        }
        if(array_key_exists('sort',$data)) {
            $info = $info->orderBy($data['sort'], 'asc');
        }

        return $info->get();
    }

    /**
     * @var data lastInfo, serverId, tempProc, tempHDD, status, dateTo, dateFrom, sort
     */
    public function get(array $data = [])
    {
        $info = DB::table($this->table)
            ->join('servers',"$this->table.server",'servers.id');

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
            $info = $info->where('enabled',$data['status']);
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

        return $info->get();
    }
}
