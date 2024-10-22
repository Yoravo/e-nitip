<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use Illuminate\Http\Request;

class LockerController extends Controller
{
    public function index()
    {
        $lockers = Locker::all(); 
        return view('welcome', compact('lockers')); 
    }
}
