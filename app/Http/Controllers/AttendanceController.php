<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function getIndex(Request $request)
    {
        // 変数取得
        $user = Auth::user();    // ユーザ情報
        $beforeDate = Carbon::now()->subDay()->endOfDay();   // 前日日時23:59:59
        $beforeYmd = $beforeDate->format('Y-m-d');   // 前日日付
        $beforeHis = $beforeDate->format('H:i:s');   // 23:59:59
        $nowYmd = Carbon::now()->format('Y-m-d');   // 現在日付
        $atte_flg = '0';                            // 勤怠中フラグ
        $rest_flg = '0';                            // 休憩中フラグ
        $beforeAttendance = $user->attendances()
                        ->where('attendance_date',$beforeYmd)
                        ->wherenull('work_end_time')
                        ->first();    // 前日の勤怠情報
        $nowAttendance = $user->attendances()
                        ->where('attendance_date',$nowYmd)
                        ->first();    // 当日の勤怠情報
        $nowRest = $user->rests()
                        ->where('attendance_date',$nowYmd)
                        ->orderBy('break_start_time','DESC')
                        ->first();    // 当日の休憩情報
        // 前日の勤怠情報チェック
        if (!empty($beforeAttendance)) {
            // 前日の勤怠情報が勤務中の場合、前日の勤怠情報を終了にする
            $beforeAttendance->update([
                'work_end_time' => $beforeHis,
            ]);

            // 前日の最後の休憩情報を取得
            $rest = $user->rests()
                        ->where('attendance_date',$beforeYmd)
                        ->orderBy('break_start_time','DESC')
                        ->first();

            // 休憩情報チェック
            if (!empty($rest)) {
                if ((isset($rest['break_end_time'])? $rest->break_end_time : null) == null) {
                    // 前日の休憩情報が休憩中の場合、前日の休憩情報を終了にする
                    // 当日の勤怠は開始しない
                    $rest->update([
                        'break_end_time' => $beforeHis,
                    ]);
                } else {
                    // 前日の休憩情報が休憩中ではない場合、当日の勤怠情報を日付変更時点から開始する
                    $startDate = Carbon::now()->startOfDay();    // 当日日時00:00:00
                    $startYmd = $startDate->format('Y-m-d');  // 当日日付
                    $startHis = $startDate->format('H:i:s');  // 00:00:00
                    $data = [
                        'user_id' => $user->id,
                        'attendance_date' => $startYmd,
                        'work_start_time' => $startHis,
                    ];
                    $user->attendances()->create($data);

                    // 勤務中フラグを更新
                    $atte_flg = '1';
                }
            } else {
                if ((isset($beforeAttendance['work_end_time'])? $beforeAttendance->work_end_time : null) !== null) {
                    // 前日の休憩情報が休憩中ではない場合、当日の勤怠情報を日付変更時点から開始する
                    $startDate = Carbon::now()->startOfDay();    // 当日日時00:00:00
                    $startYmd = $startDate->format('Y-m-d');  // 当日日付
                    $startHis = $startDate->format('H:i:s');  // 00:00:00
                    $data = [
                        'user_id' => $user->id,
                        'attendance_date' => $startYmd,
                        'work_start_time' => $startHis,
                    ];
                    $user->attendances()->create($data);

                    // 勤務中フラグを更新
                    $atte_flg = '1';
                }
            }
        }

        // 当日の勤怠情報チェック
        if(!empty($nowAttendance)) {
            // 当日の勤怠情報が既に存在する場合
            if((isset($nowAttendance['work_end_time'])? $nowAttendance->work_end_time : null) == null) {
                // 勤務中の場合、勤務中フラグを更新
                $atte_flg = '1';

                if(!empty($nowRest)) {
                    // 当日の勤怠情報が既に存在する場合
                    if ((isset($nowRest['break_end_time'])? $nowRest->break_end_time : null) == null) {
                        // 休憩中の場合、休憩中フラグを更新
                        $rest_flg = '1';
                    }
                }
            }
        }

        // 戻り値設定
        $param = [
            'user' => $user,
            'atte_flg' => $atte_flg,
            'rest_flg' => $rest_flg,
        ];

        return view('stamp',$param);
    }

    public function startAttendance() {
        // 変数を取得
        $nowYmd = Carbon::now()->format('Y-m-d');  // 当日日付
        $nowHis = Carbon::now()->format('H:i:s');  // 現在時刻
        $atte_flg = '1';                            // 勤怠中フラグ
        $rest_flg = '0';                            // 休憩中フラグ
        $user = Auth::user();                       // ユーザ情報
        $attendance = $user->attendances()
                        ->where('attendance_date',$nowYmd)
                        ->first();                   // 当日勤怠情報
        if(empty($attendance)){
            // 当日日付の勤怠情報が存在しない場合、登録
            $data = [
                'attendance_date' => $nowYmd,
                'work_start_time' => $nowHis,
                'work_end_time' => null,
            ];
            $user->attendances()->create($data);
        } else {
            // 当日日付の勤怠情報が存在する場合
            // 前回勤務終了した時間からの休憩時間を登録
            $data = [
                'attendance_date' => $nowYmd,
                'break_start_time' => $attendance->work_end_time,
                'break_end_time' => $nowHis,
            ];
            $user->rests()->create($data);
            // 当日日付の勤怠情報を継続とするよう、更新
            $attendance->update([
                'work_end_time' => null,
            ]);
        }

        // 戻り値設定
        $param = [
            'user' => $user,
            'atte_flg' => $atte_flg,
            'rest_flg' => $rest_flg,
        ];
        return back()->with($param);
    }

    public function endAttendance() {
        // 変数を取得
        $nowYmd = Carbon::now()->format('Y-m-d');  // 当日日付
        $nowHis = Carbon::now()->format('H:i:s');  // 現在時刻
        $atte_flg = '0';                            // 勤怠中フラグ
        $rest_flg = '0';                            // 休憩中フラグ
        $user = Auth::user();                       // ユーザ情報
        $attendance = $user->attendances()
                        ->where('attendance_date',$nowYmd)
                        ->first();                   // 当日勤怠情報
        $rest = $user->rests()
                        ->whereNull('break_end_time')
                        ->orderBy('break_start_time','DESC')
                        ->first();                   // 当日休暇情報

        // 当日日付の勤怠情報を更新
        $attendance->update([
            'work_end_time' => $nowHis,
        ]);

        // 休憩中(休憩終了時間がnull)の場合
        if (!empty($rest)) {
            // 当日日付の休暇情報を更新
            $rest->update([
                'break_end_time' => $nowHis,
            ]);
        }

        // 戻り値設定
        $param = [
            'user' => $user,
            'atte_flg' => $atte_flg,
            'rest_flg' => $rest_flg,
        ];

        return back()->with($param);
    }

    public function getAttendance(Request $request)
    {
        // 変数を取得
        $nowYmd = Carbon::now()->format('Y-m-d');  // 当日日付
        $nowYm = Carbon::now()->format('Y-m');  // 当年月
        $nowHis = Carbon::now()->format('H:i:s');  // 現在時刻
        $user = Auth::user();

        // 画面表示の取得する年月を設定
        if($request->ymRequest === 'back') {
            $ymItem = Carbon::parse($request->ymItem)->subMonth(1)->format('Y-m');
        } elseif ($request->ymRequest === 'next') {
            $ymItem = Carbon::parse($request->ymItem)->addMonth(1)->format('Y-m');
        } else {
            $ymItem = $nowYm;
        }

        // ページネーション表示データ取得
        $atteList = $user::select([
                'a.attendance_date',
                'a.work_start_time',
                'a.work_end_time',
                DB::raw('sec_to_time(sum(time_to_sec(timediff(r.break_end_time,r.break_start_time)))) as total_break_time'),
                DB::raw('timediff(a.work_end_time, a.work_start_time) as total_work_time'),
            ])
            ->from('attendances as a')
            ->leftJoin('rests as r', function($join) {
                $join->on('a.attendance_date', '=', 'r.attendance_date');
                $join->on('a.user_id', '=', 'r.user_id');
            })
            ->where('a.user_id', $user->id)
            ->where(DB::raw("date_format(a.attendance_date, '%Y-%m')"), $ymItem)
            ->groupBy([
                'a.attendance_date',
                'a.work_start_time',
                'a.work_end_time',
            ])
            ->orderBy('a.attendance_date')
            ->paginate(5);

        // 最も古い勤怠の年月を取得
        $oldAtteYm = $user::select(DB::raw("date_format(min(attendance_date), '%Y-%m') as oldAtteYm"))
            ->from('attendances')
            ->get();
        // ボタン活性制御判定
        $oldestYmFlg = $ymItem === $oldAtteYm[0]['oldAtteYm'] ? '1' : '0';  // 最も古い勤怠の年月の場合1、その他の場合0
        $latestYmFlg = $ymItem === $nowYm ? '1' : '0';      // 当年月の場合1、その他の場合0

        // 戻り値設定
        $param = [
            'user' => $user,
            'ymItem' => $ymItem,
            'atteList' => $atteList,
            'oldestYmFlg' => $oldestYmFlg,
            'latestYmFlg' => $latestYmFlg,
        ];

        return view('date',$param);
    }
}
