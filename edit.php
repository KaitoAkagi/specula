<!DOCTYPE html>
<?php
  // table.phpから送信されたidを保持するため、セッション開始 
   session_start();
?>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集画面</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4"
        aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="table.php"><i class="fas fa-glasses"></i> Specula</a>
      <div class="collapse navbar-collapse" id="navbarNav4">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="register.php">新規登録</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container">

    <main>
      <div class="text-center mt-5 mb-5">
        <h2>編集画面</h2>
      </div>

      <?php
        require "database.php";

        // 編集画面に遷移した後、編集する内容をテーブルで表示
        if (isset($_POST["id"])) {
            $id = htmlspecialchars($_POST["id"]);
            $stmt = exeSQL("SELECT * FROM user_table WHERE id = '".$id."' ORDER BY ip");
            $rec = $stmt->fetch(PDO::FETCH_BOTH);

            printf("<div class='table-responsive'>");
            printf("<table class='table table-bordered table-striped'>");
            printf("<thead>");
            printf("<tr>");
            printf("<th>IP</th>");
            printf("<th>名前</th>");
            printf("</tr>");
            printf("</thead>");
            printf("<tbody>");
            printf("<tr>");
            printf("<td> %s </td>", $rec["ip"]);
            printf("<td>%s</td>", $rec["name"]);
            printf("</tr>");
            printf("</tbody>");
            printf("</table>");
            printf("</div>");

            // idを保持
            $_SESSION["id"] = $id;
        }

      ?>

      <br>
      <hr>
      <br>

      <form method="POST" action="">
        <div class="form-group row">
          <label for="ip" class="col-sm-2 col-form-label">IP</label>
          <div class="col-sm-10">
            <select class="form-control" id="ip" name='ip'>
              <?php
                //ipだけ取り出す（重複なし）
                $stmt_ip = exeSQL("SELECT DISTINCT ip FROM user_table WHERE 1 ORDER BY ip");

                printf("<option value=''></option>");
                while (true) {
                  $rec = $stmt_ip->fetch(PDO::FETCH_BOTH);
                  if ($rec == false) {
                      break;
                  }
                  printf("<option value='%s'>%s</option>", $rec["ip"], $rec["ip"]);
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">名前</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id='name' name='name' placeholder='Name'>
          </div>
        </div>

        <br>
        
        <div class='form-group'>
          <div cass="form-inline">
            <button type='button' class="btn btn-dark float-left" onclick="location.href='./table.php'">戻る</button>
            <button type='submit' class="btn btn-success float-right" style="margin-left: 10px;" name='change'>変更</button>
          </div>
        </div>
      </form>

      <?php
        if (isset($_POST["change"])) {

          $id = $_SESSION["id"]; // 保存されてあるidを取得
          session_unset(); // セッション変数をすべて削除
          session_destroy(); // セッションIDおよびデータを破棄

          $ip = htmlspecialchars($_POST["ip"]); //変更後のip
          $name = htmlspecialchars($_POST["name"]); //変更後の名前

          // ipと名前が空欄のまま変更ボタンを押した場合
          if (empty($_POST["ip"])&&(empty($_POST["name"]))) {
              printf("<script>window.onload = function() {
                alert('IPか名前を入力して下さい');
                }</script>");
          // 名前が空欄の場合、名前以外を変更
          } else if (empty($name)) {
            $stmt = exeSQL("UPDATE user_table SET ip = '".$ip."' WHERE id = '".$id."'");
            header("Location: table.php");
          // ipが空欄の場合、ip以外を変更
          } else if (empty($ip)) {
            $stmt = exeSQL("UPDATE user_table SET name = '".$name."' WHERE id = '".$id."'");
            header("Location: table.php");
          // 空欄がない場合、名前とipを変更
          } else {
            $stmt = exeSQL("UPDATE user_table SET ip = '".$ip."', name = '".$name."' WHERE id = '".$id."'");
            header("Location: table.php");
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