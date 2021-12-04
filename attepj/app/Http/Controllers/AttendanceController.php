<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function getIndex()
    {
        return view('stamp');
    }

    public function getAttendance()
    {
        return view('date');
    }
}
