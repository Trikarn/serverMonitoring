<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\ServerInfo;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = new User();
        $data = [];
        if(Auth::user()->type == 'admin') {
            $allUsers = $user->users();
            $data['allUsers'] = $allUsers;
        }
        return view('servers.servers',$data);
    }

    public function create()
    {
        return view('servers.add');
    }

    public function store(Request $request, User $user)
    {
        $serverInfo = new ServerInfo();

        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'host' => ['required', 'string', 'max:255'],
            'http_port' => ['required', 'integer'],
            'https_port' => ['required', 'integer'],
            'enabled' => ['boolean'],
            'owner' => ['required', 'integer'],
        ]);

        if(!$user->isAdmin()) $data['owner'] = Auth()->id();
        $serverNew = Server::create($data);

        $newInfo = $serverInfo->add([
            'server' => $serverNew->id,
            'enabled' => 1,
            'time' => time(),
            'temp_proces' => 0,
            'load_proces' => 0,
            'temp_hard' => 0,
            'disc_mem' => 0,
            'ram' => 0,
            'speed_cooler' => 0
        ]);

        return redirect('/servers');
    }

    public function servers(Request $request)
    {
        $user = new User();
        $server = new Server();

        $data = [];
        $favorite = $request->input('favorite');
        $status = $request->input('status');
        $users = $request->input('users');


        if(!empty($favorite)) $data['favorite'] = '1';
        if($status != "") $data['status'] = $status;
        if(!empty($users) && $user->isAdmin()) $data['users'] = $users;
        
        if(!$user->isAdmin()) {
           $data['userId'] = Auth::id();
        }
        $servers = $server->servers($data);

        return $servers;
    }

    public function edit($id)
    {
        $user = new User();
        $server = new Server();

        if(!$user->isAdmin()) {
            $isLink = $server->isLink($id);
            if(!$isLink) return view('404');
        }
        $serverData = Server::findOrFail($id);
        return view('servers.manage',$serverData);
    }

    public function update($id, User $user)
    {
        $user = new User();
        $server = new Server();

        if(!$user->isAdmin()) {
            $isLink = $server->isLink($id);
            if(!$isLink) return view('404');
        }
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'host' => ['required', 'string', 'max:255'],
            'http_port' => ['required', 'integer'],
            'https_port' => ['required', 'integer'],
            'enabled' => ['boolean'],
            'owner' => ['required', 'integer'],
        ]);

        if(!$user->isAdmin()) $data['owner'] = Auth()->id();
        if(!array_key_exists('enabled',$data)) $data['enabled'] = '0';
        Server::where('id',$id)->update($data);

        return redirect('/servers');
    }

    public function favorite($id)
    {
        $serverData = Server::findOrFail($id);
        if($serverData->favorite == 1) {
            $favorite = 0;
        } else {
            $favorite = 1;
        }
        $serverData->favorite = $favorite;
        $serverData->save();

        return $favorite;
    }

    public function destroy($id, Server $server)
    {
        $user = new User();
        $server = new Server();

        if(!$user->isAdmin()) {
            $isLink = $server->isLink($id);
            if(!$isLink) return view('404');
        }
        $userType = Auth()->user()->type;
        
        $result = $server->deleteServer($id,$userType);

        return [
            'success' => 'true'
        ];
    }

}
