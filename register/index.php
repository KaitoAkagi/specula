<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4"
        aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="../index.php"><i class="fas fa-glasses"></i> Specula</a>
      
    </nav>
  </header>

  <div class="container">
    <main>
      <div class="text-center mt-5 mb-5">
        <h2>アカウント作成</h2>
      </div>

      <form method="POST" action="">
        <div class="form-group row">
          <label for="ip" class="col-sm-3 col-form-label">IP</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id='ip' name='ip' pattern="\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}" placeholder='XXX.XXX.XXX.XXX' required>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-3 col-form-label">名前</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id='name' name='name' placeholder='Name' required>
          </div>
        </div>
        <div class="form-group row">
          <label for="password" class="col-sm-3 col-form-label">パスワード</label>
          <div class="col-sm-9">
            <input type="password" class="form-control" name='password' placeholder='Password' required>
          </div>
        </div>

        <br>
        <hr>
        <br>
        <div class='form-group'>
          <button type="submit" class="btn btn-success w-100" name="register">このアカウントを作成する</button>
        </div>
      </form>

      <?php
        require "../database.php";
        require "../error_msg.php";

        session_start();

        if (isset($_POST['register'])) {
            // 未入力のデータがない場合
            if (!empty($_POST["ip"])&&(!empty($_POST["name"])&&(!empty($_POST["password"])))) {
                $ip = htmlspecialchars($_POST['ip']);
                $name = htmlspecialchars($_POST['name']);
                $password = htmlspecialchars($_POST['password']);
                // パスワードをハッシュ値に変換してデータベースに保存
                if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
                  $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
                } else {
                  echo '<script>window.onload = function() {
                    alert("パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください");
                  }</script>';
                  return false;
                }
                
                // 同じ名前のユーザーがいるか判定
                $stmt = exeSQL("SELECT name FROM user_table WHERE name='".$name."'");
                
                // 同じ名前のユーザーがいたらエラーメッセージ表示
                if ($stmt->fetch(PDO::FETCH_BOTH)) {
                  printf("<script>window.onload = function() {
                    alert('同じ名前のユーザーがすでに存在します');
                  }</script>");
                } else {

                  // 現在の時刻を取得してデータベースに保存する
                  date_default_timezone_set('Asia/Tokyo'); //東京の日付に合わせる
                  $time = date("Y/m/d H:i:s");

                  // テーブル"user_table"に名前とパスワードを追加
                  $stmt = exeSQL("INSERT INTO user_table (name,password) values ('".$name."','".$password."')");

                  // テーブル"ip_table"に名前、ipと最終アクセス時間（time）を保存
                  $stmt = exeSQL("INSERT INTO ip_table (name,ip,time) values ('".$name."','".$ip."','".$time."')");
                  
                  $_SESSION['name'] = $name;

                  header("location: ../home");
                }
            }
        }
      ?>

    </main>
  </div>

  <footer class="footer">
    <p class="text-muted text-center">Copyright(C) Akagi Kaito All Rights Reserved.</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

</body>

</html>