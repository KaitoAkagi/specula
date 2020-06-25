// さらに表示できるテーブルがあるかによって、ボタンを表示・非表示にする関数
const next = document.getElementById('next');
const back = document.getElementById('back');
let start = 0;
let end = 10;

function switchTable() {
  if (start === 0) {
    // 最初のテーブルデータ10個を表示している場合
    back.style.display = 'none'; //戻るボタン非表示
    if (lists_len <= 10) {
      //データ数が10以下の場合
      next.style.display = 'none'; //右矢印ボタンを非表示
    } else {
      next.style.display = 'block'; //右矢印ボタンを表示
    }
  } else if (end > lists_len) {
    back.style.display = 'block';
    next.style.display = 'none';
  } else {
    back.style.display = 'block';
    next.style.display = 'block';
  }
}

//NEXTボタンが押された時
next.onclick = function () {
  // 次の10個のテーブルデータを表示
  start += 10;
  end += 10;
  switchTable();
  callApi(createTable);
};

//BACKボタンが押された時
back.onclick = function () {
  // 前の10個のテーブルデータを表示
  start -= 10;
  end -= 10;
  switchTable();
  callApi(createTable);
};
