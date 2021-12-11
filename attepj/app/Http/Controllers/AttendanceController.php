<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function getIndex(Request $request)
    {
        $user = Auth::user();
        $param = [
            'user' => $user,
        ];
        return view('stamp',$param);
    }

    public function getAttendance()
    {
        return view('date');
    }

    public function startAttendance() {
        $user = Auth::user();
        $param = [
            'user' => $user,
        ];
        return view('stamp',$param);
    }

    public function endAttendance() {
        $user = Auth::user();
        $param = [
            'user' => $user,
        ];
        return view('stamp',$param);
    }
}
