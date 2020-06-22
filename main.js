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
  if (start === 0){ // 最初のテーブルデータ10個を表示している場合
    back.style.display = 'none'; //戻るボタン非表示
    if (lists_len <= 10) { //データ数が10以下の場合
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

  //IP、ユーザー名、ログイン日時を格納
  const column = []; 
  column.push(user.ip);
  column.push(user.user);
  column.push(user.time);

  const td = Array(6); // tdタグを格納する配列
  const i = Array(3); // iタグを格納する配列

  // tdタグを作成
  for (let index = 0; index < td.length; index++) {
    td[index] = document.createElement('td');
  }

  // iタグを作成
  for (let index = 0; index < i.length; index++) {
    i[index] = document.createElement('i');
  }

  //   IP〜ログイン日時をtdタグで囲む
  for (let index = 0; index < column.length; index++) {
    td[index].innerText = column[index];
  }

  // 状態ボタン●を表示
  i[0].classList.add('fas');
  i[0].classList.add('fa-circle');
  if (user.status == 0) { // statusが0の時、状態ボタン=赤
    i[0].style.color = '#FF0000';
  } else { // statusが1の時、状態ボタン=緑
    i[0].style.color = '#78FF94';
  }
  td[3].appendChild(i[0]); //tdタグの下にiタグを入れる

  //   編集ボタンを表示
  i[1].classList.add('fas');
  i[1].classList.add('fa-edit');
  i[1].style.cursor = 'pointer';
  // ボタンをタップしたらedit.phpに遷移
  i[1].addEventListener('click', function () {
    location.href = 'edit.php?name=' + user.id;
  });
  td[4].appendChild(i[1]);

  //   削除ボタンを表示
  i[2].classList.add('fas');
  i[2].classList.add('fa-trash');
  i[2].style.cursor = 'pointer';
  i[2].addEventListener('click', function () {
    location.href = 'delete.php?name=' + user.id;
  });
  td[5].appendChild(i[2]);

  // tdタグにカラムの内容を追加
  for (let index = 0; index < td.length; index++) {
    tr.appendChild(td[index]);
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
