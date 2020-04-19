<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集画面</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
  </header>
  <main>
    <h1>登録内容の編集</h1>
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
                print "<table border=1 cellpadding=5>";
                print "<tr>";
                printf("<th> サーバー名 </th>");
                printf("<th> 登録名 </th>");
                print "</tr>";
                
                foreach ($stmt_all as $row) {
                    if ($row["user"] == $_GET["name"]) {
                        print "<tr>";
                        printf("<td> %s </td>", $row["ip"]);
                        printf("<td> %s </td>", $row["user"]);
                        print "</tr>";
                    }
                }
                print "</table>";
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

  </main>
  <footer></footer>
</body>

</html>