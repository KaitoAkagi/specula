<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
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
          <li class="nav-item active">
            <a class="nav-link" href="register.php">新規登録</a>
          </li>
          <li class="nav-item">
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
                  
                  $sql = "SELECT ip, user, status FROM server_table WHERE 1 ORDER BY ip";
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
            <select class="form-control" id="number" name="user">
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

        <div class="form-group row justify-content-center">
          <div>
            <button type="submit" class="btn btn-info" name="on">ON</button>
            <button type="submit" class="btn btn-secondary" name="off">OFF</button>
          </div>
        </div>
      </form>

      <?php
        if (isset($_POST["user"])) {
            $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
          $dbh->query('SET NAMES utf8'); //文字コードのための設定
              
          $user = $_POST["user"];
            if (isset($_POST["on"])) { //ONボタンを押したらサーバー利用開始
                $status = 1;
            } elseif (isset($_POST["off"])) { //OFFボタンを押したらサーバー利用停止
                $status = 0;
            }
                      
            $sql = "UPDATE server_table SET status = :status WHERE user = :user";
            $res = $dbh->prepare($sql);
            $params = array(':status'=>$status, ':user'=>$user);
            $res->execute($params);
            $dbh = null; //データベースから切断
          header("Location: index.php"); //削除作業後に利用者管理画面に戻る
        }
      ?>
    </main>
  </div>

  <footer class="footer">
    <p class="text-muted text-center">Copyright(C) Akagi Kaito All Rights Reserved.</p>
  </footer>

</body>

</html>