<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>使用状況の管理</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4"
        aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="index.php">BisLab Server</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="register.php">新規登録</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="status.php">使用状況の管理</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container">
    <main>
      <div class="text-center mt-5 mb-3">
        <h2>使用状況の管理</h2>
      </div>

      <?php
              try {
                  $dsn = 'mysql:dbname=server;host=localhost';
                  $user_name = 'root';
                  $password = '';
                  $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
                  $dbh->query('SET NAMES utf8'); //文字コードのための設定
                  
                  $sql = "SELECT user, status FROM server_table WHERE 1 ORDER BY ip";
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $dbh = null; //データベースから切断
              } catch (Exception $e) {
                  print 'サーバが停止しておりますので暫くお待ちください。';
                  exit();
              }
      ?>

      <form class="form-horizonal" method='POST' action=''>
        <div class="form-group">
          <label for="name" class="control-label col-xs-2">名前</label>
          <div class="col-xs-5">
            <select class="form-control" id="user" name="user">
              <?php
                while (true) {
                    $rec = $stmt->fetch(PDO::FETCH_BOTH); //データベースからデータを1つずつ取り出す
                    if ($rec == false) {
                        break;
                    } //データを取り出せなくなったらループ脱出
                    printf("<option value='%s'>%s</option>", $rec["user"], $rec["user"]);
                }
              ?>
            </select>
          </div>
        </div>

        <br>
        <button type="submit" class="btn btn-info btn-block" name="on">ON</button>
        <button type="submit" class="btn btn-secondary btn-block" name="off">OFF</button>
      </form>

      <?php
        if (isset($_POST["user"])) {
          
          // 送信されたユーザーが使用しているIPの番号を取得する処理
          $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
          $dbh->query('SET NAMES utf8'); //文字コードのための設定
          $sql = "SELECT ip FROM server_table WHERE user = :user";
          $stmt = $dbh->prepare($sql);
          $params = array(':user'=>$_POST["user"]);
          $stmt->execute($params);
          $rec = $stmt->fetch(PDO::FETCH_BOTH);
          $ip = $rec["ip"];
          
          // 同じIPのユーザー名をすべて取得し、statusを確認する
          $sql = "SELECT user, status FROM server_table WHERE ip = :ip";
          $stmt = $dbh->prepare($sql);
          $params = array(':ip'=>$ip);
          $stmt->execute($params);
          
          $judge = 0; //同じサーバーを使用しているか判定する変数 0=未使用 1=使用
          while (true) {
              $rec = $stmt->fetch(PDO::FETCH_BOTH); //データベースからデータを1つず取り出す
              if ($rec == false) {
                  break;
              } else {
                  if ($rec["status"] == 1) {
                      $judge = 1;
                  }
              }
          }
          
          if (isset($_POST["on"])) { //ONボタンを押したらサーバー利用開始
              if ($judge == 0) {
                  $status = 1;
                  header("Location: index.php"); //利用者管理画面に戻る
              } else {
                  printf("<script>window.onload = function() {
                    alert('同じサーバーを利用しているユーザーがいます');
                    }</script>");
                  $status = 0;
              }
          } elseif (isset($_POST["off"])) { //OFFボタンを押したらサーバー利用停止
              $status = 0;
              header("Location: index.php"); //利用者管理画面に戻る
          }
          
          $sql = "UPDATE server_table SET status = :status, time = :time WHERE user = :user";
          $res = $dbh->prepare($sql);
          date_default_timezone_set('Asia/Tokyo'); //東京の日付に合わせる
          $params = array(':status'=>$status, ':time'=>date("Y/m/d H:i:s"),':user'=>$_POST["user"]);
          $res->execute($params);
          $dbh = null; //データベースから切断
        }
      ?>

      <div class="text-center" id="back-button">
        <button type='button' class="btn btn-dark" onclick="location.href='./index.php'">戻る</button>
      </div>

    </main>
  </div>

  <!-- <footer class="footer">
    <p class="text-muted text-center">Copyright(C) Akagi Kaito All Rights Reserved.</p>
  </footer> -->

</body>

</html>