<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <h1> 使用状況 </h1>
        <?php
            try {
                $dsn = 'mysql:dbname=server;host=localhost';
                $user_name = 'root';
                $password = '';
                $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
                $dbh->query('SET NAMES utf8'); //文字コードのための設定

                // データベースserver_tableからすべてのデータを取り出し、番号の昇順にならべる
                $sql = "SELECT num, user, status FROM server_table WHERE 1 ORDER BY num";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $dbh = null; //データベースから切断

                printf("<form method='POST' action='index.php'>");
                printf("<p>ユーザー名：");
                printf("<select name='user'>");
                while (true) {
                    $rec = $stmt->fetch(PDO::FETCH_BOTH); //データベースからデータを1つずつ取り出す
                    if ($rec == false) break; //データを取り出せなくなったらループ脱出
                    printf("<option value='%s'>%s</option>",$rec["user"],$rec["user"]);                    
                }
                printf("</select>");
                printf("</p>");
                printf("<input type='submit' name='on' value='On'>");
                printf("<input type='submit' name='off' value='Off'>");
                printf("</form>");
            } catch (Exception $e) {
                print 'サーバが停止しておりますので暫くお待ちください。';
                exit();
            }
        ?>

    </body>
</html>