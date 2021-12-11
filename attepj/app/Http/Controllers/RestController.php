<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestController extends Controller
{
    public function startRest() {
        $user = Auth::user();
        $param = [
            'user' => $user,
        ];
        return view('stamp',$param);
    }

    public function endRest() {
        $user = Auth::user();
        $param = [
            'user' => $user,
        ];
        return view('stamp',$param);
    }
}
