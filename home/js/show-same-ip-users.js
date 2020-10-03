const lists = document.getElementById('lists')

/**
 * ログインユーザーと同じサーバーのIPアドレスを登録しているユーザーを表示する関数
 * @param {string} users APIから送られてきたユーザーの情報をJSON形式で受け取る
 *
 */
function showSameIpUsers(users) {
  if (lists.textContent) lists.textContent = null
  users.forEach(function (user) {
    addUser(user)
  })
}

/**
 *
 * @param {array} user ユーザー情報（名前・IPアドレス・最終アクセス日時・使用状況）を要素とする配列
 */
function addUser (user) {
  const tr = document.createElement('tr')
  const td = Array(4)
  const i = document.createElement('i')

  for (let i = 0; i < td.length; i++) {
    td[i] = document.createElement('td')
  }

  td[0].innerText = user.ip
  td[1].innerText = user.name
  td[2].innerText = user.time

  // 状態ボタン●を表示
  i.classList.add('fas')
  i.classList.add('fa-circle')

  switch (user.status) {
    case '0':
      i.style.color = '#FF0000'
      break
    case '1':
      i.style.color = '#78FF94'
      break
  }

  td[3].appendChild(i)

  td.forEach(data => {
    tr.appendChild(data)
  })
  lists.appendChild(tr)
}
