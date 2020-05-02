const next = document.getElementById('next');
const back = document.getElementById('back');
let count = 0;

const url = 'dbconnect.php';
const lists = document.getElementById('lists');
let lists_len = 0;

// NEXT・BACKボタンで更新できるデータがあるか判定する関数
function isUpdate() {
  console.log(lists_len);
  if (count === 0) {
    back.style.display = 'none';
    next.style.display = 'block';
  } else if((count + 1) * 10 > lists_len){
    back.style.display = 'block';
    next.style.display = "none";
  } else {
    back.style.display = 'block';
    next.style.display = 'block';
  }
}

// APIを叩き、データベース情報を返す関数
async function callAPI() {
  const res = await fetch(url);
  const users = await res.json(); //json形式に変換
  lists_len = users.length;
  createTable(users);
}

// テーブルを作成する関数
function createTable(users) {
  if(lists.textContent) lists.textContent = null;
  for (let i = 10 * count; i < 10 * (count + 1); i++) {
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

  const column = [];
  column.push(user.ip);
  column.push(user.user);
  column.push(user.time);

  const td = Array(6);
  const i = Array(3);

  for (let index = 0; index < td.length; index++) {
    td[index] = document.createElement('td');
  }

  for (let index = 0; index < i.length; index++) {
    i[index] = document.createElement('i');
  }

  //   IP〜ログイン日時を表示
  for (let index = 0; index < column.length; index++) {
    td[index].innerText = column[index];
  }

  // 状態ボタンを表示
  i[0].classList.add('fas');
  i[0].classList.add('fa-circle');
  if (user.status == 0) {
    i[0].style.color = '#FF0000';
  } else {
    i[0].style.color = '#78FF94';
  }
  td[3].appendChild(i[0]);

  //   編集ボタンを表示
  i[1].classList.add('fas');
  i[1].classList.add('fa-edit');
  i[1].style.cursor = 'pointer';
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
  count++;
  isUpdate();
  callAPI();
};

//BACKボタンが押された時
back.onclick = function () {
  if (count > 0) count--;
  isUpdate();
  callAPI();
};