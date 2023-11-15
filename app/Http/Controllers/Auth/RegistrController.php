<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrController extends Controller
{
    public function signup(RegistrRequest $request){
        $res = User::create($request->all());
        return response()->json([
            'message' => $res ? 'User registred' : 'error',
            'data' => (bool)$res
        ]);
    }
}
