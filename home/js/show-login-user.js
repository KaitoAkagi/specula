const login_lists = document.getElementById('login-lists');
const login_name = document.getElementById('login-name');

// ログインユーザーの名前・IP・スイッチを表示する関数
function showLoginUser(users) {
  // すでに表示してあるテーブルがある場合、そのテーブルを削除する
  if (login_lists.textContent) login_lists.textContent = null;
  if (login_name.textContent) login_name.textContent = null;

  showName(users[0]);
  showIpAndSwitch(users[0]);
}

// スイッチが押された時に2つのテーブルを更新する関数
async function updateTables(url, key, value) {
  // post送信
  const request = new FormData();
  request.append(key, value);
  const res = await fetch(url, { method: 'POST', body: request });

  // 同じIPをもつユーザーの情報を表示
  callApi('../php/api.php?type=same_server_user', sameUsers);

  // ログインしているユーザーの使用状況を表示
  callApi('../php/api.php?type=login_user', showLoginUser);
}

// 名前を表示する関数
function showName(user) {
  const p = document.createElement('p')

  p.innerText = user.name
  login_name.appendChild(p)
}

// IPアドレスと使用状況を切り替えるスイッチを表示する関数
function showIpAndSwitch(user) {
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
    updateTables('php/status.php', 'ip', user.ip);
  });
  td[1].appendChild(i); //tdタグの下にiタグを入れる

  // trタグにtdタグの内容を追加
  for (let i = 0; i < td.length; i++) {
    tr.appendChild(td[i]);
  }

  login_lists.appendChild(tr); //listsの直下にtrタグを追加
}
