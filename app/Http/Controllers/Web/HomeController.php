<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('home.index');
    }

    public function updateLocation(Request $request, $userId)
    {
        $location = Location::updateOrCreate([
            "user_id" => $userId
        ], $request->all());

        return back()->withInput();
    }
}
