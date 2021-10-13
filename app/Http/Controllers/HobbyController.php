<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hobby;

class HobbyController extends Controller
{
    /**
     * Display a listing of the hobbies.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hobbies = Hobby::select('hobby_id','name')->get();
        return view('employee_modal', ['hobbies' => $hobbies]);

        // return response()->json([
        //     'success' => true,
        //     'data' => $hobbies
        // ]);
    }
}
