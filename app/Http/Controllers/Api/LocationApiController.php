<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryParameter = $request->query();
        $userId = null;
        if (!empty($queryParameter)) {
            $userId = $queryParameter['user_id'];
        }

        $locations = is_null($userId) ? Location::all() : Location::where('user_id', $userId)->get();

        return response()->json(['data' => $locations], 200);
    }


    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $location = Location::find($id);
        return response()->json(['data' => $location]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId)
    {

        $location = Location::updateOrCreate([
            "user_id" => $userId
        ], $request->all());

        return response()->json(["data" => $location]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = Location::destroy($id);

        return response($result > 0 ? 'Success' : 'Failed');
    }
}
