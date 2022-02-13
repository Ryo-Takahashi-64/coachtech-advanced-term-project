// 画面起動時の画面の活性・非活性を制御
function actibityControl() {
  const back__item = document.getElementById('back__item');
  const next__item = document.getElementById('next__item');
  // oldestFlgが'1'(最も古い勤怠の年月)の場合
  if (Laravel.oldestFlg === '1') {
    // 「<」ボタンを非活性にする
    back__item.classList.toggle('disabled__item');
  }
  // latestFlgが'1'(当年月)の場合
  if (Laravel.latestFlg === '1'){
    // 「>」ボタンを非活性にする
    next__item.classList.toggle('disabled__item');
  }
}

// 画面起動時処理
document.addEventListener('DOMContentLoaded', function () {
  // 画面活性制御呼び出し
  actibityControl();
});
