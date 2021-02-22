<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServersController extends Controller
{
    //
    public function index(Request $request)
    {
        // print_r($request->session()->all());
        return view('servers.servers');
    }

    public function create()
    {
        return view('servers.add');
    }

    public function store(Request $request, User $user)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'host' => ['required', 'string', 'max:255'],
            'http_port' => ['required', 'integer'],
            'https_port' => ['required', 'integer'],
            'enabled' => ['boolean'],
            'owner' => ['required', 'integer'],
        ]);

        if(!$user->isAdmin()) $data['owner'] = Auth()->id();
        Server::create($data);

        return redirect('/servers');
    }

    public function servers(Request $request)
    {
        $user = new User();
        $server = new Server();

        $data = [];
        $favorite = $request->input('favorite');
        if(!empty($favorite)) $data['favorite'] = '1';
        
        if(!$user->isAdmin()) {
           $data['userId'] = Auth::id();
        }
        $servers = $server->servers($data);

        return $servers;
    }

    public function edit($id)
    {
        $serverData = Server::findOrFail($id);
        return view('servers.manage',$serverData);
    }

    public function update($id, User $user)
    {
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
        $userType = Auth()->user()->type;
        
        $result = $server->deleteServer($id,$userType);

        return [
            'success' => 'true'
        ];
    }

}
