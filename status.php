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
      <div class="collapse navbar-collapse" id="navbarNav4">
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
      <div class="text-center mt-5 mb-5">
        <h2>使用状況の管理</h2>
      </div>

      <?php
          try {
              $dsn = 'mysql:dbname=bislab;host=localhost';
              $user_name = 'root';
              $password = '';
              $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
              $dbh->query('SET NAMES utf8'); //文字コードのための設定
                  
              $sql = "SELECT user, status FROM user_table WHERE 1 ORDER BY ip";
              $stmt = $dbh->prepare($sql);
              $stmt->execute();
              $dbh = null; //データベースから切断
          } catch (Exception $e) {
              printf("<script>window.onload = function() {
              alert('サーバが停止しておりますので暫くお待ちください');
              }</script>");
              exit();
          }
      ?>

      <form class="form-horizonal" method='POST' action=''>
        <div class="form-group">
          <label for="name" class="control-label">名前</label>
          <div>
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
            $sql = "SELECT ip FROM user_table WHERE user = :user";
            $stmt = $dbh->prepare($sql);
            $params = array(':user'=>$_POST["user"]);
            $stmt->execute($params);
            $rec = $stmt->fetch(PDO::FETCH_BOTH);
            $ip = $rec["ip"];
          
            // 同じIPのユーザー名をすべて取得し、statusを確認する
            $sql = "SELECT user, status FROM user_table WHERE ip = :ip";
            $stmt = $dbh->prepare($sql);
            $params = array(':ip'=>$ip);
            $stmt->execute($params);
          
            $judge = 0; //同じサーバーを使用しているか判定する変数 0=未使用 1=使用
            while (true) {
                $rec = $stmt->fetch(PDO::FETCH_BOTH); //データベースからデータを1つず取り出す
                if ($rec == false) {
                    break;
                } else {
                    if (($rec["user"] != $_POST["user"])&&($rec["status"] == 1)) {
                        $judge = 1;
                    }
                }
            }
          
            if (isset($_POST["on"])) { //ONボタンを押したらサーバー利用開始
                if ($judge == 0) { //同じサーバーの利用者が他にいなかったら
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
          
            $sql = "UPDATE user_table SET status = :status, time = :time WHERE user = :user";
            $res = $dbh->prepare($sql);
            date_default_timezone_set('Asia/Tokyo'); //東京の日付に合わせる
            $params = array(':status'=>$status, ':time'=>date("Y/m/d H:i:s"),':user'=>$_POST["user"]);
            $res->execute($params);
            $dbh = null; //データベースから切断
        }
      ?>

      <br>
      <hr>
      <br>
      <button type='button' class="btn btn-dark float-left" onclick="location.href='./index.php'">戻る</button>

    </main>
  </div>

  <!-- <footer class="footer">
    <p class="text-muted text-center">Copyright(C) Akagi Kaito All Rights Reserved.</p>
  </footer> -->

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

</body>

</html>