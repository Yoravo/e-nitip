<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use Illuminate\Http\Request;

class LockerController extends Controller
{
    public function index()
    {
        $lockers = Locker::all(); // Fetch all lockers
        return view('welcome', compact('lockers')); // Pass the lockers data to the view
    }
}
