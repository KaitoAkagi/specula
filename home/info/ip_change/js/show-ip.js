/**
 * ログインユーザーが登録しているIPアドレスを表示する関数
 * @param {array} users ログインユーザーのIPアドレスを格納する
 */
function showAllIp (users) {
  users.forEach(user => {
    showIp(user)
  })
}

function showIp (user) {
  const registerdIp = document.getElementById('registerd_ip')
  const option = document.createElement('option')

  option.innerText = user.ip
  option.setAttribute('value', user.ip)
  registerdIp.appendChild(option)
}
