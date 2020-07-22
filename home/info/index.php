<!DOCTYPE html>
<?php
  //  ログイン状態を保持するためのsession
   session_start();
?>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>アカウントの基本情報</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../css/styles.css">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav4"
        aria-controls="navbarNav4"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="../index.php"><i class="fas fa-glasses"></i> Specula</a>
      <div class="collapse navbar-collapse" id="navbarNav4">
        <ul class="navbar-nav">
          <li class="nav-item dropdown active">
            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              アカウント
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">基本情報</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="../logout.php">ログアウト</a>
            </div>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="../table">テーブル</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container">

    <main>
      <div class="text-center mt-5 mb-5">
        <h2>基本情報</h2>
      </div>

      <div class="wrapper">
        <div class="bold item">名前</div>
        <?php
          echo("<div class='data'>".$_SESSION["name"]."</div>")
        ?>
        <a href="update_name"><i class="fas fa-edit"></i></a>
      </div>
      <hr>
      <div class="wrapper">
        <div class="bold item">パスワード</div>
        <a href="update_pwd"><i class="fas fa-edit"></i></a>
      </div>
      <hr>
      <div class="wrapper">
        <div class="bold item">IP</div>
        <div class="data">
          <?php
            require "../../dbconnect.php";

            $stmt = exeSQL("SELECT * FROM ip_table WHERE name = '".$_SESSION["name"]."'");
            $count=$stmt->rowCount(); //抽出できたレコード数をcountに格納

            $i = 0;
            // ユーザー$_SESSION["name"]が所持しているIPアドレスを全て表示する
            foreach($stmt as $row){
              $i++;
              echo($row["ip"]);
              // IPアドレス同士の間に,を入れる
              if($i < $count){
                echo(", ");
              }
            }
          ?>
        </div>
        <a href="update_ip"><i class="fas fa-edit"></i></a>
      </div>

      <button class="btn btn-danger account-delete w-100" onclick="location.href='delete.php'">このアカウントを削除する</button>

      <?php
        if (isset($_POST["change"])) {

          $ip = htmlspecialchars($_POST["ip"]); //変更後のip
          $name = htmlspecialchars($_POST["name"]); //変更後のname

          // ipと名前が空欄のまま変更ボタンを押した場合
          if (empty($ip)&&(empty($name))) {
              printf("<script>window.onload = function() {
                alert('IPか名前を入力して下さい');
                }</script>");
          // 名前が空欄の場合、ipを変更
          } else if (empty($name)) {
            $stmt = exeSQL("UPDATE ip_table SET ip = '".$ip."' WHERE name = '".$_SESSION["name"]."'");
            header("Location: index.php");
          // ipが空欄の場合、名前を変更
          } else if (empty($ip)) {
            $stmt = exeSQL("UPDATE user_table SET name = '".$name."' WHERE name = '".$_SESSION["name"]."'");
            $stmt = exeSQL("UPDATE ip_table SET name = '".$name."' WHERE name = '".$_SESSION["name"]."'");
            $_SESSION["name"] = $name;
            header("Location: index.php");
          // 空欄がない場合、名前とipを変更
          } else {
            $stmt = exeSQL("UPDATE user_table SET name = '".$name."' WHERE name = '".$_SESSION["name"]."'");
            $stmt = exeSQL("UPDATE ip_table SET ip = '".$ip."', name = '".$name."' WHERE name = '".$_SESSION["name"]."'");
            $_SESSION["name"] = $name;
            header("Location: index.php");
          }
        }
      ?>
    </main>
  </div>

  <footer class="footer">
    <p class="text-muted text-center">Copyright(C) Akagi Kaito All Rights Reserved.</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
</body>

</html>