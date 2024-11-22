<?php

namespace App\Http\Controllers;

class PendingController extends Controller
{
    public function index()
    {
        return view('pending');
    }
}