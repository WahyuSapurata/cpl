<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth as RequestsAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Auth extends BaseController
{
    public function show()
    {
        return view('auth.login');
    }

    public function login_proses(RequestsAuth $authRequest)
    {
        $credential = $authRequest->getCredentials();

        if (!FacadesAuth::attempt($credential)) {
            return redirect()->route('login.login-akun')->with('failed', 'Username atau Password salah')->withInput($authRequest->only('username'));
        } else {
            return $this->authenticated();
        }
    }

    public function authenticated()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard-admin');
        } elseif (auth()->user()->role === 'operator') {
            return redirect()->route('operator.dashboard-operator');
        } elseif (auth()->user()->role === 'kajur') {
            return redirect()->route('kajur.dashboard-kajur');
        } elseif (auth()->user()->role === 'dosen') {
            return redirect()->route('dosen.dashboard-dosen');
        }
    }

    public function logout()
    {
        FacadesAuth::logout();
        return redirect()->route('login.login-akun')->with('success', 'Berhasil Logout');
    }
}
