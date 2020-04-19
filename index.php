<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BisLab Server</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>
  <header>
  </header>
  <main>

    <div class="container">
      <div class="text-center my-4">
        <h1 class="mb-4">登録者リスト</h1>
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
                print "<div class='table-responsive'>";
                print "<table class='table table-bordered table-striped'>";
                print "<thead>";
                print "<tr>";
                printf("<th>#</th>");
                printf("<th>名前</th>");
                printf("<th>編集</th>");
                printf("<th>削除</th>");
                print "</tr>";
                print "</thead>";
                print "<tbody>";
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
                    printf("<td><input type=\"button\" value=\"編集\" onClick=\"location.href='edit.php?name=%s'\"></td>", $rec["user"]);
                    printf("<td><input type=\"button\" value=\"削除\" onClick=\"location.href='delete.php?name=%s'\"></td>", $rec["user"]);
                    print "</tr>";
                }
                print "</tbody>";
                print "</table>";
                print "</div>";
            } catch (Exception $e) {
                print 'サーバが停止しておりますので暫くお待ちください。';
                exit();
            }
        ?>

      <br>
      <div class="text-center my-4">
        <input type="button" value="新規登録" onClick="location.href='register.php'">
        <input type="button" value="使用状況の管理" onClick="location.href='status.php'">
      </div>

    </div>
  </main>
  <footer>
  </footer>

</body>

</html>