<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BisLab</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>

    </header>
    <main>
        <h1>BisLab Server</h1>

        <h2>Status</h2>
        <?php
            try{
                $dsn = 'mysql:dbname=server;host=localhost';
                $user = 'root';
                $password = '';
                $dbh = new PDO($dsn, $user, $password); //データベースに接続
                $dbh->query('SET NAMES utf8'); //文字コードのための設定
                
                $sql = "SELECT num,name FROM server_table WHERE 1";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $dbh = null; //データベースから切断
                print "<table border=5>";
                print "<tr>";
                printf("<th>サーバー名</td>");
                printf("<th>使用者</td>");
                print "</tr>";

                while(true){
                    $rec=$stmt->fetch(PDO::FETCH_BOTH);
                    if($rec==false) break;
                    print "<tr>";
                    printf("<td> %s </td>", $rec["num"]); //サーバー名表示
                    printf("<td> %s </td>", $rec["name"]); //使用者表示
                    print "</tr>";                  
                }
                        
                print "</table>";
            }
            catch(Exception $e){
                print 'サーバが停止しておりますので暫くお待ちください。';
                exit();	
            }
?>

        <div>

            <h2>List</h2>

            <table border="5">
                <tr>
                    <th>162</th>
                    <th>164</th>
                    <th>169</th>
                    <th>175</th>
                    <th>178</th>
                    <th>186</th>
                </tr>
                <tr>
                    <td>下本</td>
                    <td></td>
                    <td>満河</td>
                    <td>廣澤</td>
                    <td>三宅</td>
                    <td>ハッチー</td>
                </tr>
                <tr>
                    <td>栗ちゃん</td>
                    <td></td>
                    <td>高司</td>
                    <td></td>
                    <td></td>
                    <td>JIN</td>
                </tr>
            </table>
        </div>
        
        <select name="person" size="1">
            <option value="A">下本</option>
            <option value="B">栗ちゃん</option>
            <option value="C">満河</option>
        </select>

        <button type="submit">start</button>
        <button type="submit">stop</button>
    </main>
    <footer></footer>
</body>
</html>