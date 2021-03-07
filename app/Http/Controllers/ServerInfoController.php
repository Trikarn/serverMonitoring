<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\ServerInfo;
use App\Models\User;
use Illuminate\Http\Request;

class ServerInfoController extends Controller
{
    
    public $critTempProc = 90;
    public $critTempHDD = 85;
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id, Request $request)
    {
        $data = [
            'id' => $id
        ];
        return view('servers.information.information', $data);
    }

    public function show($idInfo, Request $request)
    {
        $user = new User();
        $serverInfo = new ServerInfo();

        if(!$user->isAdmin()) {
            $isLink = $serverInfo->isLink($idInfo);
            if(!$isLink) return view('404');
        }

        $information = $serverInfo->get([
            'infoId' => $idInfo
        ]);

        $information = (array) $information[0];

        return view('servers.information.show', $information);
    }

    public function showInfo($id, Request $request)
    {
        $user = new User();
        $serverInfo = new ServerInfo();
        $server = new Server();

        if(!$user->isAdmin()) {
            $isLinkServer = $server->isLink($id);
            if(!$isLinkServer) return view('404');
        }

        $lastInfo = $serverInfo->get([
            'serverId' => $id,
            'lastInfo' => true
        ]);

        $information = $serverInfo->information([
            'serverId' => $id,
        ]);

        $avgTemp = 0;
        $avgSpeedCool = 0;
        $avgLoadProc = 0;
        $avgRam = 0;
        $avgTempHDD = 0;

        foreach($information as $oneInfo) {
            $avgTemp += $oneInfo->temp_proces;
            $avgSpeedCool += $oneInfo->speed_cooler;
            $avgLoadProc += $oneInfo->load_proces;
            $avgRam += $oneInfo->ram;
            $avgTempHDD += $oneInfo->temp_hard;
        }

        $count = count($information);
        $avgTemp = round($avgTemp / $count);
        $avgSpeedCool = round($avgSpeedCool / $count);
        $avgLoadProc = round($avgLoadProc / $count);
        $avgRam = round($avgRam / $count /1024, 2);
        $avgTempHDD = round($avgTempHDD / $count);

        $critTempProc = $serverInfo->get([
            'serverId' => $id,
            'tempProc' => $this->critTempProc,
            'lastInfo' => true
        ]);
        $critTempHDD = $serverInfo->get([
            'serverId' => $id,
            'tempHDD' => $this->critTempHDD,
            'lastInfo' => true
        ]);

        $lastDisable = $serverInfo->get([
            'serverId' => $id,
            'lastInfo' => true,
            'status' => 0
        ]);

        $data = [
            'serverId' => $id,
            'lastInfo' => $lastInfo,
            'average' => [
                'avgTemp' => $avgTemp,
                'avgSpeedCool' => $avgSpeedCool,
                'avgLoadProc' => $avgLoadProc,
                'avgRam' => $avgRam,
                'avgTempHDD' => $avgTempHDD,
            ],
            'critical' => [
                'critTempProc' => $critTempProc,
                'critTempHDD' => $critTempHDD,
                'lastDisable' => $lastDisable,
            ]
        ];

        // print_r($data);
        return view('servers.information.info',$data);
    }

    public function information($id, Request $request)
    {
        $user = new User();
        $serverInfo = new ServerInfo();
        $server = new Server();

        if(!$user->isAdmin()) {
            $isLinkServer = $server->isLink($id);
            if(!$isLinkServer) return view('404');
        }

        $data = [
            'serverId' => $id,
        ];
        $enabled = $request->input('status');
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');
        $sort = $request->input('sort');
        $limit = $request->input('limit');
        $offset = $request->input('offset');

        if($enabled || $enabled == '0') $data['enabled'] = $enabled;
        if($dateFrom && is_numeric($dateFrom)) $data['dateFrom'] = $dateFrom;
        if($dateTo && is_numeric($dateTo)) $data['dateTo'] = $dateTo;
        if($sort) $data['sort'] = $sort;
        if($limit) $data['limit'] = $limit;
        if($offset) $data['offset'] = $offset;
        
        $information = $serverInfo->information($data);

        unset($data['offset']);
        unset($data['limit']);
        $data['count'] = true;
        $count = $serverInfo->information($data);

        return [
            'information' => $information,
            'count' => $count
        ];
        // return $data;
    }
}
