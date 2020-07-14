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
  <title>名前の変更</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../css/style.css">
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
      <a class="navbar-brand" href="../../index.php"><i class="fas fa-glasses"></i> Specula</a>
      <div class="collapse navbar-collapse" id="navbarNav4">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              アカウント
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="../">基本情報</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="../../logout.php">ログアウト</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container">

    <main>
      <div class="text-center mt-5 mb-5">
        <h2>名前の変更</h2>
      </div>

      <form method="POST" action="">
        <div class="form-group">
          <label for="old_name">現在</label>
          <?php
            echo("<input type='text' class='form-control' name='old_name' value='".$_SESSION['name']."' readonly>");
          ?>
        </div>
        <div class="form-group">
          <label for="new_name">新規</label>
          <input type="text" class="form-control" name='new_name' placeholder='Name'>
        </div>
        <br>
        <button type='submit' class="btn btn-success w-100" name='change' >変更する</button>
      </form>

      <?php
        require "../../../database.php";

        // 変更ボタンが押された時に実行
        if (isset($_POST["change"])) {

          $new_name = htmlspecialchars($_POST["new_name"]); //変更後のname

          // 名前が空欄のまま変更ボタンを押した場合
          if (empty($new_name)) {
              printf("<script>window.onload = function() {
                alert('名前を入力して下さい');
                }</script>");
          // 名前が空欄の場合、ipを変更
          } else {
            // 2つのテーブルの名前を変更
            $stmt = exeSQL("UPDATE user_table SET name = '".$new_name."' WHERE name = '".$_SESSION["name"]."'");
            $stmt = exeSQL("UPDATE ip_table SET name = '".$new_name."' WHERE name = '".$_SESSION["name"]."'");

            // セッションで保持している名前も変更
            $_SESSION["name"] = $new_name;

            // 基本情報の画面に戻る
            header("Location: ../index.php");
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