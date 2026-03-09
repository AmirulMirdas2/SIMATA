<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard');
    }

    public function mitra()
    {
        return view('mitra.dashboard');
    }

    public function penumpang()
    {
        return view('penumpang.dashboard');
    }
}
