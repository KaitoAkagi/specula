<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
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
          <li class="nav-item active">
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
      <div class="text-center mt-5 mb-3">
        <h2>新規登録</h2>
      </div>
      <?php
        if (isset($_POST['register'])) {
            if (empty($_POST["ip"])) {
                printf("<script>alert('IPを入力して下さい');</script>");
            } else if (empty($_POST["user"])){
                printf("<script>alert('名前を入力して下さい');</script>");
            } else {
                $ip = htmlspecialchars($_POST['ip']);
                $user = htmlspecialchars($_POST['user']);
                print "<hr>";
                print "<div class='table-responsive'>";
                print "<table class='table table-bordered table-striped'>";
                print "<thead>";
                print "<tr>";
                printf("<th>IP</th>");
                printf("<th>名前</th>");
                print "</tr>";
                print "</thead>";
                print "<tbody>";
                print "<tr>";
                printf("<th scope='row'> %s </th>", $ip);
                printf("<td> %s </td>", $user);
                print "</tr>";
                print "</tbody>";
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
                        printf("<script>alert('この人物は既に登録済みです');</script>");
                    } else {
                        $sql = "INSERT INTO server_table (ip,user) values (?,?)";
                        $stmt = $dbh->prepare($sql);
                        $data[] = $ip;
                        $data[] = $user;
                        $stmt->execute($data);
                        print "<div class='text-center'>";
                        print "<p>データを登録しました</p>";
                        print "</div>";
                        print "<hr>";
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
          <div class='col-sm-12'>
            <input type='text' class='form-control' id='exampleInputName2' name='ip' placeholder='IP'>
          </div>
        </div>
        <div class='form-group'>
          <label for='exampleInputName2' class='col-sm-2 control-label'>名前</label>
          <div class='col-sm-12'>
            <input type='text' class='form-control' id='exampleInputName2' name='user' placeholder='Name'>
          </div>
        </div>
        <br>
        <div class='form-group'>
          <div class='col-sm-offset-2 col-sm-10'>
            <button type="submit" class="btn btn-success" name="register">登録</button>
          </div>
        </div>
      </form>
    </main>
  </div>

  <footer class="footer">
    <p class="text-muted text-center">Copyright(C) Akagi Kaito All Rights Reserved.</p>
  </footer>
</body>

</html>