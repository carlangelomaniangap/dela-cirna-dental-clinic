<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\CommunityForum;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        $communityforums = CommunityForum::all();
        $communityforums = CommunityForum::paginate(3);
        return view('welcome', compact('communityforums'));
    }
}
