// 画面起動時の勤務状態により画面の活性・非活性を制御
function actibityControl() {
  const atteStartTarget = document.getElementById('atte__start');
  const atteEndTarget = document.getElementById('atte__end');
  const restStartTarget = document.getElementById('rest__start');
  const restEndTarget = document.getElementById('rest__end');
  // 勤務中フラグが'1'の場合
  if (Laravel.atte_flg === '1') {
    // 勤務開始ボタンを非活性にする
    atteStartTarget.classList.toggle('disabled__item');

    // 休憩中フラグが'1'の場合
    if (Laravel.rest_flg === '1') {
      // 休憩開始ボタンを非活性にする
      restStartTarget.classList.toggle('disabled__item');
    } else {
      // 休憩終了ボタンを非活性にする
      restEndTarget.classList.toggle('disabled__item');
    }
  } else {
    // 勤務終了、休憩開始、休憩終了ボタンを非活性にする
    atteEndTarget.classList.toggle('disabled__item');
    restStartTarget.classList.toggle('disabled__item');
    restEndTarget.classList.toggle('disabled__item');
  }
}

// 日付変更時にページの再読み込みを行う
function dateChange() {
  // 現在の時刻を秒数で取得
  const now = new Date();
  const currentS = (now.getHours() * 60 + now.getMinutes()) * 60 + now.getSeconds();

  // 目標時刻を秒数にする
  const targetS = (24 * 60 + 0) * 60;
  let timeDiffS = targetS - currentS;

  // 目標時刻を過ぎている場合1日加算する
  if (timeDiffS < 0) {
    timeDiffS += 24 * 60 * 60;
  }
  // timeDiffS秒後に画面をリロード(日付変更処理実行)
  setTimeout("location.reload()", timeDiffS * 1000);
}

// 画面起動時処理
document.addEventListener('DOMContentLoaded', function () {
  // 画面活性制御呼び出し
  actibityControl();

  // 日付変更処理呼び出し
  dateChange();
});
