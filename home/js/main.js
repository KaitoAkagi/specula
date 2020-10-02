// 同じIPをもつユーザーの情報を表示
callApi('../php/api.php?type=same_server_user', sameUsers);

// ログインしているユーザーの使用状況を表示
callApi('../php/api.php?type=login_user', showLoginUser);
