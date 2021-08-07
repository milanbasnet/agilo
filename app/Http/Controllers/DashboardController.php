<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class DashboardController extends Controller
{
    //
    public function index()
    {
        $hideBreadcrumb = true;

        $user = Auth::user();
        $user->load(['office', 'groups.athletes', 'role']);
        
        return view('pages.dashboard', compact('hideBreadcrumb', 'user'));
    }
}
