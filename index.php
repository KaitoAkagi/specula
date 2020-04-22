<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BisLab Server</title>
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
          <li class="nav-item">
            <a class="nav-link" href="status.php">使用状況の管理</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container">
    <main>
      <div class="text-center" id="title">
        <h1>Built for BisLab members.</h1>
      </div>

      <?php
            try {
                $dsn = 'mysql:dbname=server;host=localhost';
                $user_name = 'root';
                $password = '';
                $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
                $dbh->query('SET NAMES utf8'); //文字コードのための設定
                // データベースserver_tableからすべてのデータを取り出し、番号の昇順にならべる
                $sql = "SELECT ip, user, status FROM server_table WHERE 1 ORDER BY ip";
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
              <th>編集</th>
              <th>削除</th>
            </tr>
          </thead>
          <tbody>
            <?php
                while (true) {
                    $rec = $stmt->fetch(PDO::FETCH_BOTH); //データベースからデータを1つずつ取り出す
                    if ($rec == false) {
                        break;
                    } //データを取り出せなくなったらループ脱出
                    print "<tr>";
                    printf("<th scope='row'>%s</th>", $rec["ip"]);
                    if ($rec["status"]==1) { //サーバー利用時は色を変える
                        printf("<td style='background-color: #78FF94;'> %s </td>", $rec["user"]);
                    } else {
                        printf("<td> %s </td>", $rec["user"]);
                    }
                    printf("<td><button type=\"button\" class=\"btn btn-info btn-sm \"
                  onClick=\"location.href='edit.php?name=%s' \">編集</button></td>", $rec["user"]);
                    printf("<td><button type=\"button\" class=\"btn btn-danger btn-sm\"
                  onClick=\"location.href='delete.php?name=%s' \">削除</button></td>", $rec["user"]);
                    print "</tr>";
                }
              ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <footer class=" footer">
    <p class="text-muted text-center">Copyright(C) Akagi Kaito All Rights Reserved.</p>
  </footer>

</body>

</html>