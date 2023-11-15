<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('web.auth.layout.app');
    }

    public function login(LoginRequest $request){
        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect()->route('home');
        } else {
            return redirect()->back();
        }
        //return view('web.auth.login');
    }

    public function show($id){
        $user = User::find($id);
        return view('web.user.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request){
        $data = [
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email
        ];
        $res = User::where('id',$request->id)->update($data);
        if($res){
            return redirect()->route('home');
        }else{
            return redirect()->back();
        }
    }

    public function logout()
    {
        auth()->logout();
        // session()->destroy();
        return redirect()->route('login.index');
    }
}
