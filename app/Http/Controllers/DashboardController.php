<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,delete users');
    }

    public function index()
    {
        return "Dashboard admin";
    }
}
