<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BisLab Server</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
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
  <!-- <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
  </header> -->

  <div class="container">
    <main>
      <div class="text-center" id="title">
        <h1>Built for BisLab members.</h1>
      </div>

      <?php
            try {
                $dsn = 'mysql:dbname=bislab;host=localhost';
                $user_name = 'root';
                $password = '';
                $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
                $dbh->query('SET NAMES utf8'); //文字コードのための設定
                // データベースserver_tableからすべてのデータを取り出し、番号の昇順にならべる
                $sql = "SELECT ip, user, status, time FROM user_table WHERE 1 ORDER BY ip";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $dbh = null; //データベースから切断
            } catch (Exception $e) {
                print 'サーバが停止しておりますので暫くお待ちください。';
                exit();
            }
      ?>

      <!-- table -->
      <div class='table-responsive'>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>IP</th>
              <th>名前</th>
              <th>状態</th>
              <th>ログイン日時</th>
              <th>編集</th>
              <th>削除</th>
            </tr>
          </thead>
          <tbody>
            <?php
            
                try {
                  $dsn = 'mysql:dbname=bislab;host=localhost';
                  $username = 'root';
                  $password = '';
                  $dbh = new PDO($dsn, $username, $password); //データベースに接続
                  $dbh->query('SET NAMES utf8'); //文字コードのための設定
                  // データベースserver_tableからすべてのデータを取り出し、番号の昇順にならべる
                  $sql = "SELECT id, ip, user, status, time FROM user_table WHERE 1 ORDER BY ip";
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $dbh = null; //データベースから切断
                } catch (Exception $e) {
                  print 'サーバが停止しておりますので暫くお待ちください。';
                }
                
                while (true) {
                    $rec = $stmt->fetch(PDO::FETCH_BOTH); //データベースからデータを1つずつ取り出す
                    if ($rec == false) {
                        break;
                    } //データを取り出せなくなったらループ脱出
                    print "<tr>";
                    printf("<th scope='row'>%s</th>", $rec["ip"]);
                    printf("<td> %s </td>", $rec["user"]);
                    if ($rec["status"]==1) { //サーバー利用時は色を変える
                      printf("<td><i class=\"fas fa-circle\" style=\"color: #78FF94;\"></i></td>");
                    } else {
                      printf("<td><i class=\"fas fa-circle\" style=\"color: #FF0000;\"v></i></td>");
                    }
                    printf("<td>%s</td>", $rec["time"]);
                    printf("<td><i class=\"fas fa-edit\" style=\"cursor: pointer;\" onClick=\"location.href='edit.php?name=%s'\"></i>", $rec["id"]);
                    printf("<td><i class=\"fas fa-trash\" style=\"cursor: pointer;\" onClick=\"location.href='delete.php?name=%s'\"></i></td>", $rec["user"]);
                    print "</tr>";
                }
              ?>
          </tbody>
        </table>
      </div>
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