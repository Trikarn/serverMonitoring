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

    public function index(Request $request)
    {
        return view('servers.information.information');
    }

    public function show($id, Request $request)
    {

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
        $avgTemp = $avgTemp / $count;
        $avgSpeedCool = $avgSpeedCool / $count;
        $avgLoadProc = $avgLoadProc / $count;
        $avgRam = $avgRam / $count;
        $avgTempHDD = $avgTempHDD / $count;

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
        $enabled = $request->input('enabled');
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');
        $sort = $request->input('sort');


        if($enabled) $data['enabled'] = $enabled;
        if($dateFrom) $data['dateFrom'] = $dateFrom;
        if($dateTo) $data['dateTo'] = $dateTo;
        if($sort) $data['sort'] = $sort;
        
        $information = $serverInfo->information($data);

        return $information;
    }
}
