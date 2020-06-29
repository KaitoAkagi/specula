<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>使用状況の管理</title>
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
          <li class="nav-item">
            <a class="nav-link" href="register.php">新規登録</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="status.php">使用状況の管理</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container">
    <main>
      <div class="text-center mt-5 mb-5">
        <h2>使用状況の管理</h2>
      </div>

      <?php
          require "function.php";

          $stmt = exeSQL("SELECT * FROM user_table WHERE 1 ORDER BY ip");
      ?>

      <form class="form-horizonal" method='POST' action=''>
        <div class="form-group">
          <label for="name" class="control-label">名前</label>
          <div>
            <select class="form-control" id="id" name="id"> 
              <?php
                while (true) {
                    $rec = $stmt->fetch(PDO::FETCH_BOTH); //データベースからデータを1つずつ取り出す
                    if ($rec == false) {
                        break;
                    } //データを取り出せなくなったらループ脱出
                    printf("<option value='%s'>%s</option>", $rec["id"], $rec["name"]);
                }
              ?>
            </select>
          </div>
        </div>

        <br>
        <button type="submit" class="btn btn-info btn-block" name="on">ON</button>
        <button type="submit" class="btn btn-secondary btn-block" name="off">OFF</button>
      </form>

      <?php
        // if (isset($_POST["id"])) {

        //     // 送信されたidの名前とipを取得
        //     $id = htmlspecialchars($_POST["id"]);
        //     $stmt = exeSQL("SELECT ip, name FROM user_table WHERE id = '".$id."'");
          
        //     if (isset($_POST["on"])) { //ONボタンを押したらサーバー利用開始
        //         $status = 1;
        //         header("Location: index.html"); //利用者管理画面に戻る
        //     } elseif (isset($_POST["off"])) { //OFFボタンを押したらサーバー利用停止
        //         $status = 0;
        //         header("Location: index.html"); //利用者管理画面に戻る
        //     }

        //     date_default_timezone_set('Asia/Tokyo'); //東京の日付に合わせる
        //     $time = date("Y/m/d H:i:s");
        //     $stmt = exeSQL("UPDATE user_table SET status = '".$status."', time = '".$time."' WHERE id = '".$id."'");
        // }

        if (isset($_POST["id"])) {
          // 送信されたidの名前とipを取得
          $id = htmlspecialchars($_POST["id"]);
          $stmt = exeSQL("SELECT status FROM user_table WHERE id = '".$id."'");
          $rec = $stmt->fetch(PDO::FETCH_BOTH);
          $status = $rec["status"];

          if($status == 0) $status = 1;
          else $status = 0;

          date_default_timezone_set('Asia/Tokyo'); //東京の日付に合わせる
          $time = date("Y/m/d H:i:s");
          $stmt = exeSQL("UPDATE user_table SET status = '".$status."', time = '".$time."' WHERE id = '".$id."'");
          
          // header("Location: index.html");//ホームページに戻る
        }
      ?>

      <br>
      <hr>
      <br>
      <button type='button' class="btn btn-dark float-left" onclick="location.href='./index.html'">戻る</button>

    </main>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

  <footer class="footer">
    <p class="text-muted text-center">Copyright(C) Akagi Kaito All Rights Reserved.</p>
  </footer>

</body>

</html>