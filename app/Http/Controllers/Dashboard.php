<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends BaseController
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->back();
        }
        return redirect()->route('login.login-akun');
    }

    public function dashboard_admin()
    {
        $module = 'Dashboard';
        return view('dashboard.admin', compact('module'));
    }

    public function dashboard_operator()
    {
        $module = 'Dashboard';
        return view('dashboard.operator', compact('module'));
    }

    public function dashboard_kajur()
    {
        $module = 'Dashboard';
        return view('dashboard.kajur', compact('module'));
    }

    public function dashboard_lpm()
    {
        $module = 'Dashboard';
        return view('dashboard.lpm', compact('module'));
    }

    public function dashboard_dosen()
    {
        $module = 'Dashboard';
        return view('dashboard.dosen', compact('module'));
    }
}
