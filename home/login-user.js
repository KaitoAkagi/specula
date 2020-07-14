const login_lists = document.getElementById('login-lists');

// ログインユーザーと同じIPを登録しているユーザーを表示する関数
// start+1番目からend-1番目のテーブルデータを表示する
function loginUser(users) {
  // すでに表示してあるテーブルがある場合、そのテーブルを削除する
  if (login_lists.textContent) login_lists.textContent = null;
  users.forEach(function (user) {
    addUser(user);
  });
}

// スイッチが押された時に2つのテーブルを更新する関数
async function updateTables(url, key, value){

  // post送信
  const request = new FormData(); //フォームデータ作成
  request.append(key, value);
  const res = await fetch(url, { method: 'POST', body: request });
  
  // ログインしているユーザーの使用状況を表示
  callApi("api_login_user.php",loginUser);

  // 同じIPをもつユーザーの情報を表示
  callApi("api.php",sameUsers);

}

// テーブルにログインユーザーを追加する関数
function addUser(user) {
  const tr = document.createElement('tr');
  const td = Array(2); // tdタグを格納する配列

  // tdタグを作成
  for (let i = 0; i < td.length; i++) {
    td[i] = document.createElement('td');
  }

  //   IPをtdタグで囲む
  td[0].innerText = user.ip;

  // iタグを作成
  const i = document.createElement('i');

  // 状態ボタン●を表示
  i.classList.add('fas');
  i.classList.add('fa-lg');
  // statusが0の時、状態ボタン=赤
  if (user.status == 0) {
    i.classList.add('fa-toggle-off');
    i.style.color = '#FF0000';
  // statusが1の時、状態ボタン=緑
  } else {
    i.classList.add('fa-toggle-on');
    i.style.color = '#78FF94';
  }
  i.style.cursor = 'pointer';
  // スイッチを押した時、テーブルを更新
  i.addEventListener('click', function () {
    updateTables('status.php', 'ip', user.ip);
  });
  td[1].appendChild(i); //tdタグの下にiタグを入れる

  // trタグにtdタグの内容を追加
  for (let i = 0; i < td.length; i++) {
    tr.appendChild(td[i]);
  }

  login_lists.appendChild(tr); //listsの直下にtrタグを追加
}
