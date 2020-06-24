const url = 'dbconnect.php'; // web APIのURL
const lists = document.getElementById('lists');
const next = document.getElementById('next');
const back = document.getElementById('back');
let start = 0;
let end = 10;
let lists_len = 0;

// 更新できるテーブルがあるかによって、ボタンを表示・非表示にする関数
// ここの処理はもう少しわかりやすくかけるかも
function isUpdate() {
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

// APIを叩き、データベース情報を返す関数
async function callAPI() {
  const res = await fetch(url);
  const users = await res.json(); //json形式に変換
  lists_len = users.length; //データの総数を変数lists_lenに格納
  createTable(users);
}

// テーブルを作成する関数
// start+1番目からend-1番目のテーブルデータを表示する
function createTable(users) {
  // すでに表示してあるテーブルがある場合、そのテーブルを削除する
  if (lists.textContent) lists.textContent = null;
  for (let i = start; i < end; i++) {
    if (i < users.length) {
      addList(users[i]);
    } else {
      break;
    }
  }
}

// テーブルにデータベースのデータを追加する関数
function addList(user) {

  const tr = document.createElement('tr');

  const td = Array(6); // tdタグを格納する配列
  
  // tdタグを作成
  for (let i = 0; i < td.length; i++) {
    td[i] = document.createElement('td');
  }

  //   IP〜ログイン日時をtdタグで囲む
  td[0].innerText = user.ip;
  td[1].innerText = user.name;
  td[2].innerText = user.time;

  const i_tag = Array(3); // iタグを格納する配列

  // iタグを作成
  for (let i = 0; i < i_tag.length; i++) {
    i_tag[i] = document.createElement('i');
  }

  // 状態ボタン●を表示
  i_tag[0].classList.add('fas');
  i_tag[0].classList.add('fa-circle');
  if (user.status == 0) {
    // statusが0の時、状態ボタン=赤
    i_tag[0].style.color = '#FF0000';
  } else {
    // statusが1の時、状態ボタン=緑
    i_tag[0].style.color = '#78FF94';
  }
  i_tag[0].style.cursor = 'pointer';
  i_tag[0].addEventListener('click', function () {
    location.href = 'status.php?id=' + user.id + '&status=' + user.status;
  });
  td[3].appendChild(i_tag[0]); //tdタグの下にiタグを入れる

  //   編集ボタンを表示
  i_tag[1].classList.add('fas');
  i_tag[1].classList.add('fa-edit');
  i_tag[1].style.cursor = 'pointer';
  // ボタンをタップしたらedit.phpに遷移
  i_tag[1].addEventListener('click', function () {
    location.href = 'edit.php?name=' + user.id;
  });
  td[4].appendChild(i_tag[1]);

  //   削除ボタンを表示
  i_tag[2].classList.add('fas');
  i_tag[2].classList.add('fa-trash');
  i_tag[2].style.cursor = 'pointer';
  i_tag[2].addEventListener('click', function () {
    location.href = 'delete.php?name=' + user.id;
  });
  td[5].appendChild(i_tag[2]);

  // trタグにtdタグの内容を追加
  for (let i = 0; i < td.length; i++) {
    tr.appendChild(td[i]);
  }

  lists.appendChild(tr); //listsの直下にtrタグを追加
}

callAPI(); //APIを叩く

//NEXTボタンが押された時
next.onclick = function () {
  // 次の10個のテーブルデータを表示
  start += 10;
  end += 10;
  isUpdate();
  callAPI();
};

//BACKボタンが押された時
back.onclick = function () {
  // 前の10個のテーブルデータを表示
  start -= 10;
  end -= 10;
  isUpdate();
  callAPI();
};
