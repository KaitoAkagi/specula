/**
 * ログインユーザーの登録情報（名前・IP）を表示する関数
 * @param {array} users ログインユーザーの名前・IPアドレスを格納する
 */
function showLoginUserInfo (users) {
  showName(users[0])
  showIp(users)
}

/**
 * ログインユーザーの名前を表示する関数
 * @param {array} user ログインユーザーの名前・IPアドレスを格納する
 */
function showName (user) {
  const loginName = document.getElementById('login-name')
  loginName.innerText = user.name
}

/**
 * ログインユーザーの登録しているIPアドレスを表示する関数
 * @param {array} users ログインユーザーの名前・IPアドレスを格納する
 */
function showIp (users) {
  const loginIp = document.getElementById('login-ip');
  let allIp = ''

  for (let i = 0; i < users.length; i++) {
    allIp += users[i].ip
    if (i < users.length - 1) {
      allIp += ', '
    }
  }

  loginIp.innerText = allIp
}
