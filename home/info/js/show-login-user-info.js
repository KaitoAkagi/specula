// テーブルにログインユーザーを追加する関数
function showLoginUserInfo(users) {
  showName(users[0]);
  showIp(users);
}

function showName(user) {
  const login_name = document.getElementById('login-name');
  login_name.innerText = user.name;
}

function showIp(users) {
  const login_ip = document.getElementById('login-ip');
  let all_ip = ''; 
  for (let i = 0; i < users.length; i++) {
    all_ip += users[i].ip
    if (i < users.length - 1) {
      all_ip += ', '
    }
  }
  console.log(all_ip);
  login_ip.innerText = all_ip
}