<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // use HasFactory;
    protected $quarded = array('id');

    public static $rules = array(
        'user_id' => 'required',
        'attendance_date' => 'required',
        'work_start_time' => 'required',
    );
}
