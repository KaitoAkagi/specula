const lists = document.getElementById('lists')

/**
 * 全てのユーザーの使用状況等を表示する関数
 * @param {array} users ユーザーの名前・IPアドレス・最終アクセス日時・状態を取得する
 */
function showAllUsers(users) {
  if (lists.textContent) lists.textContent = null
  users.forEach(function (user) {
    showUser(user)
  })
}

/**
 * ユーザーの名前・IP・最終アクセス日時・状態を表示する関数
 * @param {array} user ユーザーの名前・IP・最終アクセス日時・状態を取得する
 */
function showUser (user) {
  const tr = document.createElement('tr')
  const td = Array(4)

  for (let i = 0; i < td.length; i++) {
    td[i] = document.createElement('td')
  }

  //   IP〜最終アクセス日時をtdタグで囲む
  td[0].innerText = user.ip
  td[1].innerText = user.name
  td[2].innerText = user.time

  const i = document.createElement('i')

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
