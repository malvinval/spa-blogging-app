<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {
        $route_name = Route::current()->getName();
        $userName = Auth::user()->name;

        return Inertia::render("Dashboard", [
            "route_name" => $route_name,
            "user_name" => $userName
        ]);
    }
}
