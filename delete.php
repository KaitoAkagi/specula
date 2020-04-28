<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> 削除 </title>
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
      <?php
        if (isset($_GET["name"])) {
            try {
                $dsn = 'mysql:dbname=bislab;host=localhost';
                $user_name = 'root';
                $password = '';
                $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
                $dbh->query('SET NAMES utf8'); //文字コードのための設定
                                
                $sql = "SELECT ip, user FROM user_table WHERE 1";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $dbh = null; //データベースから切断
            } catch (Exception $e) {
                print 'サーバが停止しておりますので暫くお待ちください。';
                exit();
            }
            
            foreach ($stmt as $row) {
                if ($row["user"] == $_GET["name"]) {
                    print "<div class='text-center mt-5 mb-5'>";
                    print "<h2>削除しますか？</h2>";
                    print "</div>";
                    print "<div class='table-responsive'>";
                    print "<table class='table table-bordered table-striped'>";
                    print "<thead>";
                    print "<tr>";
                    printf("<th>IP</th>");
                    printf("<th>名前</th>");
                    print "</tr>";
                    print "</thead>";
                    print "<tbody>";
                    print "<tr>";
                    printf("<th scope='row'>%s</th>", $row["ip"]);
                    printf("<td>%s</td>", $row["user"]);
                    print "</tr>";
                    print "</tbody>";
                    print "</table>";
                    print "</div>";
                    print "<br>";
                }
            }
        }
            
        if (isset($_POST['delete'])) {
            $name = $_GET['name'];
            try {
                $dsn = 'mysql:dbname=bislab;host=localhost';
                $user = 'root';
                $password = '';
                $dbh = new PDO($dsn, $user, $password); //データベースに接続
                $dbh->query('SET NAMES utf8'); //文字コードのための設定
            
                $sql = "DELETE FROM user_table WHERE user = :user";
                $stmt = $dbh->prepare($sql);
                $data = array(':user' => $_GET['name']);
                $stmt->execute($data);
                $dbh = null; //データベースから切断
                header("Location: index.php"); //削除作業後に利用者管理画面に戻る
                exit();
            } catch (Exception $e) {
                print 'サーバが停止しておりますので暫くお待ちください。';
                exit();
            }
        }
                
    ?>

      <br>
      <hr>
      <br>
      <form method="post" action="">
        <div class='form-group'>
          <div cass="form-inline">
            <button type="button" class="btn btn-secondary float-left" onClick="location.href='index.php'">Cancel</button>
            <button type="submit" class="btn btn-danger float-right" name="delete">Delete</button>
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