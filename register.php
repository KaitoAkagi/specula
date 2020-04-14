<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<h3> 使用者登録 </h3>
<?php
    if(isset($_POST['register'])){
        $num = htmlspecialchars($_POST['num']);
        $name = htmlspecialchars($_POST['name']);
        if((!isset($num))or(!isset($name))){
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
            printf("<td> %s </td>", $name);
            print "</tr>";
            print "</table>";
            
            try{
                $dsn = 'mysql:dbname=server;host=localhost';		$user = 'root';		$password = '';
                $dbh = new PDO($dsn, $user, $password); //データベースに接続
                $dbh->query('SET NAMES utf8'); //文字コードのための設定
                print "<hr>";
                
                $sql = "SELECT num,name FROM server_table WHERE name='".$name."'";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                if($stmt->fetch(PDO::FETCH_BOTH)!=false){
                    print "この人物は既に登録済みです<hr>";
                }else{
                    $sql = "INSERT INTO server_table (num,name) values (?,?)";
                    $stmt = $dbh->prepare($sql);
                    $data[] = $num;
                    $data[] = $name;
                    $stmt->execute($data);
                    print "データを登録しました<hr>";
                } 	
                $dbh = null; //データベースから切断	
            }catch(Exception $e){
                print 'サーバが停止しておりますので暫くお待ちください。';
                exit();	
            }
        }
    print '</select><br>';
    }
?>

        <form method="POST" action="">
            <p>サーバー名：
            <!-- name="sever_name"を変更 -->
            <select name="num">
                <option value="162">162</option>
                <option value=164>164</option>
                <option value=169>169</option>
                <option value=175>175</option>
                <option value=178>178</option>
                <option value=186>186</option>
            </select>
            </p>
            <p>登録名:<input type="text" name="name"></p>
            <input type="submit" name="register" value="登録" style="margin-top: 20px"> 
            <input type="button" value="使用者リストに戻る" onClick="location.href='index.php'">
        </form>

    </body>
</html>