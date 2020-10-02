// ログインユーザーが登録しているIPアドレスを表示する関数
function showIp(users) {
  const registerd_ip = document.getElementById('registerd_ip');

  users.forEach(user => {
    const option = document.createElement('option');
    option.innerText = user.ip;
    option.setAttribute('value', user.ip);
    registerd_ip.appendChild(option);
  });
}