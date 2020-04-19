<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集画面</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
  <header></header>
  <main>
    <div class="container">
      <div class="text-center my-4">
        <h1 class="mb-4">登録内容の編集</h1>
      </div>
      <?php
        
        try {
            $dsn = 'mysql:dbname=server;host=localhost';
            $user_name = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
            $dbh->query('SET NAMES utf8'); //文字コードのための設定

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
                print "<p>変更前</p>";
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
            
            printf("<form method='post' action=''>");
            printf("<p>サーバー名を変更する</p>");
            printf("<select name='ip'>");
            while (true) {
                $rec = $stmt_ip->fetch(PDO::FETCH_BOTH);
                if ($rec == false) {
                    break;
                }
                printf("<option value='%s'>%s</option>", $rec["ip"], $rec["ip"]);
            }
            printf("</select>");
            printf("<input type='submit' name='changeIp' value='変更'>");
            printf("<p>登録名を変更する</p>");
            printf("<input type='text' name='user'>");
            printf("<input type='submit' name='changeUser' value='変更'>");
            printf("</form>");
        } catch (Exception $e) {
            print 'サーバが停止しておりますので暫くお待ちください。';
            exit();
        }
        
    ?>

      <br>
      <input type="button" value="登録者リストに戻る" onClick="location.href='index.php'">
    </div>

  </main>
  <footer></footer>
</body>

</html>