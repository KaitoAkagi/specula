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
        <h3> 使用者登録 </h3>
        <?php
            if(isset($_POST['register'])){
                $num = htmlspecialchars($_POST['num']);
                $user = htmlspecialchars($_POST['user']);
                if((!isset($num))or(!isset($user))){
                    echo '登録されていない項目があります<BR>';
                }
                else{
                    print "<hr>";
                    print "入力されたデータ<BR>";
                    print "<table border=1 cellpadding=5>";
                    print "<tr>";
                    printf("<th> サーバー名 </td>");
                    printf("<th> 登録名 </td>");
                    print "</tr>";
                    print "<tr>";
                    printf("<td> %s </td>", $num);
                    printf("<td> %s </td>", $user);
                    print "</tr>";
                    print "</table>";
                    
                    try{
                        $dsn = 'mysql:dbname=server;host=localhost';  $user_name = 'root'; $password = '';
                        $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
                        $dbh->query('SET NAMES utf8'); //文字コードのための設定
                        print "<hr>";
                        
                        $sql = "SELECT num, user FROM server_table WHERE user='".$user."'";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute();
                        if($stmt->fetch(PDO::FETCH_BOTH)!=false){
                            print "この人物は既に登録済みです<hr>";
                        }else{
                            $sql = "INSERT INTO server_table (num,user) values (?,?)";
                            $stmt = $dbh->prepare($sql);
                            $data[] = $num;
                            $data[] = $user;
                            $stmt->execute($data);
                            print "データを登録しました<hr>";
                        } 	
                        $dbh = null; //データベースから切断	
                    }catch(Exception $e){
                        print 'サーバが停止しておりますので暫くお待ちください。';
                        exit();	
                    }
                    print '</select><br>';
                }
            }

            try {
                $dsn = 'mysql:dbname=server;host=localhost';
                $user_name = 'root';
                $password = '';
                $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
                $dbh->query('SET NAMES utf8'); //文字コードのための設定

                // データベースserver_tableからすべてのデータを取り出し、番号の昇順にならべる
                $sql = "SELECT DISTINCT num FROM server_table WHERE 1 ORDER BY num";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $dbh = null; //データベースから切断

                printf("<form method='POST' action=''>");
                printf("<p>サーバー名：");
                printf("<select name='num'>");
                while (true) {
                    $rec = $stmt->fetch(PDO::FETCH_BOTH); //データベースからデータを1つずつ取り出す
                    if ($rec == false) break; //データを取り出せなくなったらループ脱出
                    printf("<option value='%s'>%s</option>",$rec["num"],$rec["num"]);                    
                }
                printf("</select>");
                printf("</p>");
                printf("<p>登録名:<input type='text' name='user'></p>");
                printf("<input type='submit' name='register' value='登録'>");
                printf("</form>");

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