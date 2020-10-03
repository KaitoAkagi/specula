const loginLists = document.getElementById('login-lists')
const loginName = document.getElementById('login-name')

/**
 * ログインユーザーの名前・IP・スイッチを表示する関数
 * @param {array} users ログインしているユーザーの名前・IPアドレス・使用状況を受け取る
 */
function showLoginUser (users) {
  if (loginLists.textContent) loginLists.textContent = null
  if (loginName.textContent) loginName.textContent = null

  showName(users[0])
  showIpAndSwitch(users[0])
}

/**
 * スイッチが押された時に2つのテーブルを更新する関数
 * @param {string} url ポスト送信をしたいURL（相対パス）
 * @param {*} key 送信したい変数の名前
 * @param {*} value 送信したい値
 */
async function updateTables (url, key, value) {
  const request = new FormData()
  request.append(key, value)
  const res = await fetch(url, { method: 'POST', body: request })

  callApi('../php/api.php?type=same_server_user', showSameIpUsers)
  callApi('../php/api.php?type=login_user', showLoginUser)
}

/**
 * 名前を表示する関数
 * @param {JSON} user ユーザー情報
 */
function showName (user) {
  const p = document.createElement('p')

  p.innerText = user.name
  loginName.appendChild(p)
}

/**
 * IPアドレスと使用状況を切り替えるスイッチを表示する関数
 * @param {string} user ログインユーザーのIPアドレス・使用状況
 */
function showIpAndSwitch (user) {
  const tr = document.createElement('tr')
  const td = Array(2)

  for (let i = 0; i < td.length; i++) {
    td[i] = document.createElement('td')
  }

  td[0].innerText = user.ip

  const i = document.createElement('i')

  // 使用状況を切り替えるスイッチを表示
  i.classList.add('fas')
  i.classList.add('fa-lg')

  switch (user.status) {
    case '0':
      i.classList.add('fa-toggle-off');
      i.style.color = '#FF0000'
      break
    case '1':
      i.classList.add('fa-toggle-on');
      i.style.color = '#78FF94'
      break
  }

  i.style.cursor = 'pointer'
  // スイッチを押した時、ホーム画面を更新
  i.addEventListener('click', function () {
    updateTables('php/status.php', 'ip', user.ip)
  })
  td[1].appendChild(i)

  td.forEach(data => {
    tr.appendChild(data)
  })

  loginLists.appendChild(tr)
}
