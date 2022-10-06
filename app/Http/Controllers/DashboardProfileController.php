<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class DashboardProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route_name = Route::current()->getName();
        $user = Auth::user();

        return Inertia::render("DashboardProfile", [
            "route_name" => $route_name,
            "user" => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        $route_name = Route::current()->getName();
        $countries = file_get_contents(base_path() . "/public/js/countries.json");
        $countries = json_decode($countries, true);

        return Inertia::render("EditProfilePage", [
            "route_name" => $route_name,
            "countries" => $countries,
            "user" => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $bio = $request->params["bio"];
        $fullname = $request->params["fullname"];
        $status = $request->params["status"];
        $country = $request->params["country"];

        $user->update([
            "status" => $status,
            "name" => $fullname,
            "bio" => $bio,
            "country" => $country
        ]);

        return response()->json([
            "success" => "Your profile has been updated !",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
