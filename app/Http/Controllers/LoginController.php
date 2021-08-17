<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Model\User;
use App\Services\Params\User\CreateUserServiceParams;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function create()
    {
        return view('login.create');
    }

    public function store(CreateUserRequest $request)
    {
        var_dump($request->name);
        var_dump($request->email);
        var_dump($request->password);
        #return "algo $request";

        $params = new CreateUserServiceParams(
            $request->name,
            $request->email,
            $request->password
        );

        $params = $params->toArray();
        var_dump($params['name']);

        if ($params) {
            User::make($params);
        }

        return redirect('/login');
    }
}
