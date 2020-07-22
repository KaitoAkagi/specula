const lists = document.getElementById('lists');

// ログインユーザーと同じIPを登録しているユーザーを表示する関数
// start+1番目からend-1番目のテーブルデータを表示する
function allUsers(users) {
  // すでに表示してあるテーブルがある場合、そのテーブルを削除する
  if (lists.textContent) lists.textContent = null;
  users.forEach(function (user) {
    addList(user);
  });
}

// テーブルにデータベースのデータを追加する関数
function addList(user) {
    const tr = document.createElement('tr');
    const td = Array(4); // tdタグを格納する配列
  
    // tdタグを作成
    for (let i = 0; i < td.length; i++) {
      td[i] = document.createElement('td');
    }
  
    //   IP〜ログイン日時をtdタグで囲む
    td[0].innerText = user.ip;
    td[1].innerText = user.name;
    td[2].innerText = user.time;
  
    // iタグを作成
    const i = document.createElement('i');
  
    // 状態ボタン●を表示
    i.classList.add('fas');
    i.classList.add('fa-circle');
    if (user.status == 0) {
      // statusが0の時、状態ボタン=赤
      i.style.color = '#FF0000';
    } else {
      // statusが1の時、状態ボタン=緑
      i.style.color = '#78FF94';
    }
    td[3].appendChild(i); //tdタグの下にiタグを入れる
  
    // trタグにtdタグの内容を追加
    for (let i = 0; i < td.length; i++) {
      tr.appendChild(td[i]);
    }
  
    lists.appendChild(tr); //listsの直下にtrタグを追加
}