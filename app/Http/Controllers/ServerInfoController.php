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

    public function show($id,$idInfo, Request $request)
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

        $information = (array) $information;

        // print_r($idInfo);

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
            'dateFrom' => time() - 10800, // 10800 - seconds in 3 hours,
            'dateTo' => time()
        ]);

        $fullTempProc = [];
        $fullTempHDD = [];
        $fullLoadProc = [];
        $fullFanSpeed = [];
        $fullRam = [];
        $fullHDD = [];
        $fullTime = [];

        foreach($information as $oneInfo) {
            array_unshift($fullTempProc,$oneInfo->temp_proces);
            array_unshift($fullTempHDD,$oneInfo->temp_hard);
            array_unshift($fullLoadProc,$oneInfo->load_proces);
            array_unshift($fullFanSpeed,$oneInfo->speed_cooler);
            array_unshift($fullRam,round(($oneInfo->ram / 1024),2));
            array_unshift($fullHDD,round(($oneInfo->disc_mem / 1024),2));
            array_unshift($fullTime,gmdate("H:i",$oneInfo->time));
        }

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
            'full' => [
                'fullTime' => json_encode($fullTime,  JSON_HEX_QUOT   | JSON_HEX_APOS),
                'fullTempProc' => json_encode($fullTempProc),
                'fullTempHDD' => json_encode($fullTempHDD),
                'fullLoadProc' => json_encode($fullLoadProc),
                'fullFanSpeed' => json_encode($fullFanSpeed),
                'fullRam' => json_encode($fullRam),
                'fullHDD' => json_encode($fullHDD),
            ],
            'critical' => [
                'critTempProc' => $critTempProc,
                'critTempHDD' => $critTempHDD,
                'lastDisable' => $lastDisable,
            ]
        ];

        // print_r($data['full']['fullTime']);
        // print_r($information);
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
