<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RestController extends Controller
{
    public function startRest() {
        // 変数を取得
        $nowYmd = Carbon::now()->format('Y-m-d');  // 当日日付
        $nowHis = Carbon::now()->format('H:i:s');  // 現在時刻
        $atte_flg = '1';                            // 勤怠中フラグ
        $rest_flg = '1';                            // 休憩中フラグ
        $user = Auth::user();                       // ユーザ情報

        // 当日日付の休憩情報を登録
        $data = [
            'attendance_date' => $nowYmd,
            'break_start_time' => $nowHis,
            'break_end_time' => null,
        ];
        $user->rests()->create($data);

        // 戻り値設定
        $param = [
            'user' => $user,
            'atte_flg' => $atte_flg,
            'rest_flg' => $rest_flg,
        ];

        return back()->with($param);
    }

    public function endRest() {
        // 変数を取得
        $nowYmd = Carbon::now()->format('Y-m-d');  // 当日日付
        $nowHis = Carbon::now()->format('H:i:s');  // 現在時刻
        $atte_flg = '1';                            // 勤怠中フラグ
        $rest_flg = '0';                            // 休憩中フラグ
        $user = Auth::user();                       // ユーザ情報
        $rest = $user->rests()->where('attendance_date',$nowYmd)
                    ->orderBy('break_start_time','DESC')
                    ->first();    // 休憩情報

        // 当日日付の休憩情報のうち、最後の更新
        $rest->update([
            'break_end_time' => $nowHis,
        ]);

        // 戻り値設定
        $param = [
            'user' => $user,
            'atte_flg' => $atte_flg,
            'rest_flg' => $rest_flg,
        ];
        return back()->with($param);
    }
}
