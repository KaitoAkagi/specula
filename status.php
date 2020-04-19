<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>

  </header>
  <main>
    <h1> 使用状況の管理 </h1>
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

                printf("<form method='POST' action=''>");
                printf("<p>ユーザー名：");
                printf("<select name='user'>");
                while (true) {
                    $rec = $stmt->fetch(PDO::FETCH_BOTH); //データベースからデータを1つずつ取り出す
                    if ($rec == false) break; //データを取り出せなくなったらループ脱出
                    printf("<option value='%s'>%s</option>",$rec["user"],$rec["user"]);                    
                }
                printf("</select>");
                printf("</p>");
                printf("<input type='submit' name='on' value='ON'>");
                printf("<input type='submit' name='off' value='OFF'>");
                printf("</form>");

                if(isset($_POST["user"])){
					$dbh = new PDO($dsn, $user_name, $password); //データベースに接続
					$dbh->query('SET NAMES utf8'); //文字コードのための設定
		
					$user = $_POST["user"];
					if(isset($_POST["on"])){ //ONボタンを押したらサーバー利用開始
						$status = 1;
					} else if(isset($_POST["off"])){ //OFFボタンを押したらサーバー利用停止
						$status = 0;
                    }
					
					$sql = "UPDATE server_table SET status = :status WHERE user = :user";
					$res = $dbh->prepare($sql);
					$params = array(':status'=>$status, ':user'=>$user);
					$res->execute($params);
                    $dbh = null; //データベースから切断
                    header("Location: index.php"); //削除作業後に利用者管理画面に戻る
					exit();
				}

            } catch (Exception $e) {
                print 'サーバが停止しておりますので暫くお待ちください。';
                exit();
            }
        ?>
    <br>
    <input type="button" value="登録者リストに戻る" onClick="location.href='index.php'">
  </main>
  <footer>
  </footer>

</body>

</html>