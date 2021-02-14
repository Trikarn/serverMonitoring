<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServersController extends Controller
{
    //
    public function index()
    {
        return view('servers.servers');
    }

    public function create()
    {
        return view('servers.add');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'host' => ['required', 'string', 'max:255'],
            'http_port' => ['required', 'integer'],
            'https_port' => ['required', 'integer'],
            'enabled' => ['boolean'],
            'owner' => ['required', 'integer'],
        ]);

        // dd(request()->all());
        Server::create($data);


    }

}
