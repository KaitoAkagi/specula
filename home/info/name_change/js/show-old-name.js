/**
 * すでに登録しているログインユーザーの名前を表示する関数
 * @param {array} users ログインユーザーの名前を格納する
 */
function showOldName (users) {
  const oldName = document.getElementById('old_name')
  oldName.setAttribute('placeholder', users[0].name)
}
