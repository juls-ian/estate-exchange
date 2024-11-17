<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        // dd(Auth::user());
        return inertia(
            'index/Index',
            ['listings']
        );
    }

    public function show()
    {
        return inertia('index/Show');

    }
}