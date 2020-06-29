<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録</title>
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
      <a class="navbar-brand" href="index.html"><i class="fas fa-glasses"></i> Specula</a>
      <div class="collapse navbar-collapse" id="navbarNav4">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="register.php">新規登録</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container">
    <main>
      <div class="text-center mt-5 mb-5">
        <h2>新規登録</h2>
      </div>
      <?php
        require "function.php";

        if (isset($_POST['register'])) {
            if (empty($_POST["ip"])&&(empty($_POST["name"]))) {
                printf("<script>window.onload = function() {
                  alert('IPと名前を入力して下さい');
                  }</script>");
            } elseif (empty($_POST["ip"])) {
                printf("<script>window.onload = function() {
                alert('IPを入力して下さい');
                }</script>");
            } elseif (empty($_POST["name"])) {
                printf("<script>window.onload = function() {
                alert('名前を入力して下さい');
                }</script>");
            } else {
                $ip = htmlspecialchars($_POST['ip']);
                $name = htmlspecialchars($_POST['name']);
                
                $stmt = exeSQL("SELECT ip, name FROM user_table WHERE name='".$name."' AND ip='".$ip."'");
                
                if ($stmt->fetch(PDO::FETCH_BOTH)) {
                  printf("<script>window.onload = function() {
                    alert('同じIP・名前のユーザーがすでに存在します');
                  }</script>");
                } else {
                  printf("<hr>");
                  printf("<div class='table-responsive'>");
                  printf("<table class='table table-bordered table-striped'>");
                  printf("<thead>");
                  printf("<tr>");
                  printf("<th>IP</th>");
                  printf("<th>名前</th>");
                  print("</tr>");
                  print("</thead>");
                  print("<tbody>");
                  print("<tr>");
                  printf("<th scope='row'> %s </th>",$ip);
                  printf("<td> %s </td>", $name);
                  printf("</tr>");
                  printf("</tbody>");
                  printf("</table>"); 
                  printf("<hr>");

                  $stmt = exeSQL("INSERT INTO user_table (ip,name) values ('".$ip."','".$name."')");

                  print "<div class='text-center'>";
                  print "<p>データを登録しました</p>";
                  print "</div>";
                  print "<hr>";
                }
                $dbh = null; //データベースから切断
            }
        }
        ?>

      <form method="POST" action="">
        <div class="form-group row">
          <label for="ip" class="col-sm-2 col-form-label">IP</label>
          <div class="col-sm-10">
            <input type="number" min="0" class="form-control" id='ip' name='ip' placeholder='IP'>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">名前</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id='name' name='name' placeholder='Name'>
          </div>
        </div>

        <br>
        <hr>
        <br>
        <div class='form-group'>
          <div cass="form-inline">
            <button type='button' class="btn btn-dark float-left" onclick="location.href='./index.html'">戻る</button>
            <button type="submit" class="btn btn-success float-right offset-sm-8" name="register">登録</button>
          </div>
        </div>
      </form>

    </main>
  </div>

  <footer class="footer">
    <p class="text-muted text-center">Copyright(C) Akagi Kaito All Rights Reserved.</p>
  </footer>
  
  <script src="main.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

</body>

</html>