<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
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
        <h1 class="mb-4">使用者登録</h1>
      </div>

      <?php
        if (isset($_POST['register'])) {
            $ip = htmlspecialchars($_POST['ip']);
            $user = htmlspecialchars($_POST['user']);
            if ((!isset($ip))or(!isset($user))) {
                echo '登録されていない項目があります<BR>';
            } else {
                print "<hr>";
                print "入力されたデータ<BR>";
                print "<table border=1 cellpadding=5>";
                print "<tr>";
                printf("<th> サーバー名 </td>");
                printf("<th> 登録名 </td>");
                print "</tr>";
                print "<tr>";
                printf("<td> %s </td>", $ip);
                printf("<td> %s </td>", $user);
                print "</tr>";
                print "</table>";
                    
                try {
                    $dsn = 'mysql:dbname=server;host=localhost';
                    $user_name = 'root';
                    $password = '';
                    $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
                        $dbh->query('SET NAMES utf8'); //文字コードのための設定
                        print "<hr>";
                        
                    $sql = "SELECT ip, user FROM server_table WHERE user='".$user."'";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();
                    if ($stmt->fetch(PDO::FETCH_BOTH)!=false) {
                        print "この人物は既に登録済みです<hr>";
                    } else {
                        $sql = "INSERT INTO server_table (ip,user) values (?,?)";
                        $stmt = $dbh->prepare($sql);
                        $data[] = $ip;
                        $data[] = $user;
                        $stmt->execute($data);
                        print "データを登録しました<hr>";
                    }
                    $dbh = null; //データベースから切断
                } catch (Exception $e) {
                    print 'サーバが停止しておりますので暫くお待ちください。';
                    exit();
                }
                print '</select><br>';
            }
        }

        ?>

      <form method="POST" action="" class="form-horizontal">
        <div class='form-group'>
          <label for='exampleInputName2' class='col-sm-2 control-label'>IP</label>
          <div class='col-sm-10'>
            <input type='text' class='form-control' id='exampleInputName2' name='ip' placeholder='IP'>
          </div>
        </div>
        <div class='form-group'>
          <label for='exampleInputName2' class='col-sm-2 control-label'>Name</label>
          <div class='col-sm-10'>
            <input type='text' class='form-control' id='exampleInputName2' name='user' placeholder='Name'>
          </div>
        </div>
        <div class='form-group'>
          <div class='col-sm-offset-2 col-sm-10'>
            <input type='submit' name='register' value='登録'>
          </div>
        </div>
        <div class='form-group'>
          <div class='col-sm-offset-2 col-sm-10'>
            <input type="button" value="登録者リストに戻る" onClick="location.href='index.php'">
          </div>
        </div>
      </form>
    </div>
  </main>
  <footer>

  </footer>


</body>

</html>