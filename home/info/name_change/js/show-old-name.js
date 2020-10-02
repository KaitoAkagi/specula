// テーブルにログインユーザーを追加する関数
function showOldName(users) {
  const old_name = document.getElementById('old_name');
  old_name.setAttribute("placeholder", users[0].name);
}
