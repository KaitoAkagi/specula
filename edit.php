<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集画面</title>
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
        <h2>新規登録</h2>
      </div>

      <?php
        try {
            $dsn = 'mysql:dbname=server;host=localhost';
            $user_name = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
            $dbh->query('SET NAMES utf8'); //文字コードのための設定
        } catch (Exception $e) {
            print 'サーバが停止しておりますので暫くお待ちください。';
            exit();
        }

        // 全てのデータを取り出す
        $sql_all = "SELECT ip, user FROM server_table WHERE 1 ORDER BY ip";
        $stmt_all = $dbh->prepare($sql_all);
        $stmt_all->execute();

        //ipだけ取り出す
        $sql_ip = "SELECT DISTINCT ip FROM server_table WHERE 1 ORDER BY ip";
        $stmt_ip = $dbh->prepare($sql_ip);
        $stmt_ip->execute();
            
        //変更内容を反映させる
        if (isset($_POST["changeIp"])) {
            $sql_change = "UPDATE server_table SET ip = :ip WHERE user = :user";
            $res = $dbh->prepare($sql_change);
            $params = array(':ip'=>$_POST["ip"], ':user'=>$_GET["name"]);
            $res->execute($params);
            header("Location: index.php"); //削除作業後に利用者管理画面に戻る
        } elseif (isset($_POST["changeUser"])) {
            $sql_change = "UPDATE server_table SET user = :userAfter WHERE user = :userBefore";
            $res = $dbh->prepare($sql_change);
            $params = array(':userBefore'=>$_GET["name"], ':userAfter'=>$_POST["user"]);
            $res->execute($params);
            header("Location: index.php"); //削除作業後に利用者管理画面に戻る
        }
            
        $dbh = null; //データベースから切断

        if (isset($_GET["name"])) {
            print "<div class='table-responsive'>";
            print "<table class='table table-bordered table-striped'>";
            print "<thead>";
            print "<tr>";
            printf("<th>#</th>");
            printf("<th>名前</th>");
            print "</tr>";
            print "</thead>";
            print "<tbody>";

            foreach ($stmt_all as $row) {
                if ($row["user"] == $_GET["name"]) {
                    print "<tr>";
                    printf("<th scope='row'> %s </th>", $row["ip"]);
                    printf("<td>%s</td>", $row["user"]);
                    print "</tr>";
                }
            }
            print "</tbody>";
            print "</table>";
            print "</div>";
        }
      ?>

      <form method="POST" action="" class="form-horizontal">
        <div class='form-group'>
          <label for='ip' class='col-sm-8 control-label'>IPを変更する</label>
          <div class='col-cs-5'>
            <select name='ip'>
              <?php
                while (true) {
                    $rec = $stmt_ip->fetch(PDO::FETCH_BOTH);
                    if ($rec == false) {
                        break;
                    }
                    printf("<option value='%s'>%s</option>", $rec["ip"], $rec["ip"]);
                }
              ?>
            </select>
          </div>
          <input type='submit' name='changeIp' value='変更'>
        </div>
        <div class='form-group'>
          <label for='user' class='col-sm-8 control-label'>名前を変更する</label>
          <div class='col-sm-12'>
            <input type='text' class='form-control' id='user' name='user' placeholder='Name'>
          </div>
          <input type='submit' name='changeUser' value='変更'>
        </div>
        <br>
        <div class='form-group'>
          <div class='col-sm-offset-2 col-sm-10'>
            <button type="submit" class="btn btn-success" name="register">登録</button>
          </div>
        </div>
      </form>

      <form method='post' action=''>
        <p>サーバー名を変更する</p>
        <select name='ip'>
          <?php
          while (true) {
              $rec = $stmt_ip->fetch(PDO::FETCH_BOTH);
              if ($rec == false) {
                  break;
              }
              printf("<option value='%s'>%s</option>", $rec["ip"], $rec["ip"]);
          }
          ?>
        </select>
        <input type='submit' name='changeIp' value='変更'>
        <p>登録名を変更する</p>
        <input type='text' name='user'>
        <input type='submit' name='changeUser' value='変更'>
      </form>
    </main>
  </div>


  <footer class="footer">
    <p class="text-muted text-center">Copyright(C) Akagi Kaito All Rights Reserved.</p>
  </footer>
</body>

</html>