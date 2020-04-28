<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集</title>
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
          <li class="nav-item">
            <a class="nav-link" href="status.php">使用状況の管理</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container">

    <main>
      <div class="text-center mt-5 mb-5">
        <h2>編集</h2>
      </div>

      <?php
        
        try {
            $dsn = 'mysql:dbname=bislab;host=localhost';
            $user_name = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
            $dbh->query('SET NAMES utf8'); //文字コードのための設定
        } catch (Exception $e) {
            printf("<script>window.onload = function() {
            alert('サーバが停止しておりますので暫くお待ちください');
            }</script>");
            exit();
        }

        // 全てのデータを取り出す
        $sql_all = "SELECT id, ip, user FROM user_table WHERE 1 ORDER BY ip";
        $stmt_all = $dbh->prepare($sql_all);
        $stmt_all->execute();

        //ipだけ取り出す
        $sql_ip = "SELECT DISTINCT ip FROM user_table WHERE 1 ORDER BY ip";
        $stmt_ip = $dbh->prepare($sql_ip);
        $stmt_ip->execute();

        $sql = "SELECT id FROM user_table WHERE 1 ORDER BY ip";
        $stmt = $dbh->prepare($sql_all);
        $stmt->execute();

        if (isset($_POST["change"])) {
              $id = htmlspecialchars($_GET["name"]);
              $ip = htmlspecialchars($_POST["ip"]);
              $user = htmlspecialchars($_POST["user"]);

              if (empty($_POST["ip"])&&(empty($_POST["user"]))) {
                  printf("<script>window.onload = function() {
                    alert('IPか名前を入力して下さい');
                    }</script>");
              } else if (empty($_POST["user"])) {
                $sql_change = "UPDATE user_table SET ip = :ip WHERE id = :id";
                $res = $dbh->prepare($sql_change);
                $params = array(':ip'=>$ip, ':id'=>$id);
                $res->execute($params);
                header("Location: index.php"); //削除作業後に利用者管理画面に戻る
              } else if (empty($_POST["ip"])) {
                $sql_change = "UPDATE user_table SET user = :user WHERE id = :id";
                $res = $dbh->prepare($sql_change);
                $params = array(':id'=>$id, ':user'=>$user);
                $res->execute($params);
                header("Location: index.php"); //削除作業後に利用者管理画面に戻る    
              } else {
                $sql_change = "UPDATE user_table SET ip = :ip, user = :user WHERE id = :id";
                $res = $dbh->prepare($sql_change);
                $params = array(':id'=>$id, ':ip'=>$ip, ':user'=>$user);
                $res->execute($params);
                header("Location: index.php"); //削除作業後に利用者管理画面に戻る
              }
        }
            
        $dbh = null; //データベースから切断

        if (isset($_GET["name"])) {
            print "<div class='table-responsive'>";
            print "<table class='table table-bordered table-striped'>";
            print "<thead>";
            print "<tr>";
            printf("<th>IP</th>");
            printf("<th>名前</th>");
            print "</tr>";
            print "</thead>";
            print "<tbody>";

            foreach ($stmt_all as $row) {
                if ($row["id"] == $_GET["name"]) {
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

      <br>
      <hr>

      <br>

      <form method="POST" action="">
        <div class="form-group row">
          <label for="ip" class="col-sm-2 col-form-label">IP</label>
          <div class="col-sm-10">
            <select class="form-control" id="ip" name='ip'>
              <?php
                printf("<option value=''></option>");
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
        </div>
        <div class="form-group row">
          <label for="user" class="col-sm-2 col-form-label">名前</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id='user' name='user' placeholder='Name'>
          </div>
        </div>

        <br>
        
        <div class='form-group'>
          <div cass="form-inline">
            <button type='button' class="btn btn-dark float-left" onclick="location.href='./index.php'">戻る</button>
            <button type='submit' class="btn btn-success float-right" style="margin-left: 10px;" name='change'>変更</button>
          </div>
        </div>
      </form>

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