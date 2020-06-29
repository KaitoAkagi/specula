const lists = document.getElementById('lists');
let lists_len = 0;

// テーブルを作成する関数
// start+1番目からend-1番目のテーブルデータを表示する
function createTable(users) {
  lists_len = users.length; //データの総数を変数lists_lenに格納

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

// 同期通信かつPOST送信で値を送信する関数
function sendForm(url, key, value) {
  var form = document.createElement('form');
  document.body.appendChild(form);
  var input = document.createElement('input');
  input.setAttribute('type', 'hidden');
  input.setAttribute('name', key);
  input.setAttribute('value', value);
  form.appendChild(input);
  form.setAttribute('action', url);
  form.setAttribute('method', 'post');
  form.submit();
}

// テーブルにデータベースのデータを追加する関数
function addList(user) {
  const tr = document.createElement('tr');
  const td = Array(6); // tdタグを格納する配列
  const i_tag = Array(3); // iタグを格納する配列

  // tdタグを作成
  for (let i = 0; i < td.length; i++) {
    td[i] = document.createElement('td');
  }

  //   IP〜ログイン日時をtdタグで囲む
  td[0].innerText = user.ip;
  td[1].innerText = user.name;
  td[2].innerText = user.time;

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
    post('status.php', 'id', user.id, createTable);
  });
  td[3].appendChild(i_tag[0]); //tdタグの下にiタグを入れる

  //   編集ボタンを表示
  i_tag[1].classList.add('fas');
  i_tag[1].classList.add('fa-edit');
  i_tag[1].style.cursor = 'pointer';
  // ボタンをタップしたらedit.phpに遷移
  i_tag[1].addEventListener('click', function () {
    sendForm('edit.php', 'id', user.id);
  });
  td[4].appendChild(i_tag[1]);

  //   削除ボタンを表示
  i_tag[2].classList.add('fas');
  i_tag[2].classList.add('fa-trash');
  i_tag[2].style.cursor = 'pointer';
  i_tag[2].addEventListener('click', function () {
    post('delete.php', 'id', user.id, createTable);
  });
  td[5].appendChild(i_tag[2]);

  // trタグにtdタグの内容を追加
  for (let i = 0; i < td.length; i++) {
    tr.appendChild(td[i]);
  }

  lists.appendChild(tr); //listsの直下にtrタグを追加
}

// APIを叩いてcreateTableを実行する
callApi(createTable);
