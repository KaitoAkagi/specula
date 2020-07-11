<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body>
    <!-- メニューバー -->
    <header>
      <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
        <a class="navbar-brand" href=""><i class="fas fa-glasses"></i> Specula</a>
      </nav>
    </header>

    <!-- main -->
    <div class="container">
        <main>
            <div class="text-center title">
                <h1>Specula</h1>
            </div>

            <?php
              require "database.php";
              require "error_msg.php";

              session_start();

              //  ログイン済みの場合
              if(isset($_SESSION["name"])){
                header("index.php");
              }
              
              // ログインボタンを押した後の処理
              if(isset($_POST["name"])){

                //DB内でPOSTされた名前を検索
                try {
                  $stmt = exeSQL("SELECT * FROM user_table WHERE name = ?");
                  $stmt->execute([$_POST["name"]]);
                  $row = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (\Exception $e) {
                  echo $e->getMessage() . PHP_EOL;
                }

                //名前がDB内に存在しているか確認
                if (!isset($row['name'])) {
                    error_msg("名前またはパスワードが間違っています");
                } else {
                  //パスワード確認後sessionにメールアドレスを渡す
                  if (password_verify($_POST['password'], $row['password'])) {
                    session_regenerate_id(true); //session_idを新しく生成し、置き換える
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['id'] = $row['id'];
                    header("Location: home");
                  } else {
                    error_msg("名前またはパスワードが間違っています");
                  }
                }
              }
            ?>

            <div class="login-box">
                <form method="POST" action="">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">名前</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name='name' placeholder='Name'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">パスワード</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name='password' placeholder='Password'>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary center-button">ログイン</button>
                    </div>
                </form>
            </div>

            <div class="text-center sub-title">
                <p>ー 初めての方はこちら ー</p>
            </div>
            <div class="text-center">
                <a class="btn btn-success center-button" href="register/" type="button">アカウント作成</a>
            </div>
      </main>
    </div>
    
    <footer class="footer">
      <p class="text-muted text-center">Copyright(C) Akagi Kaito All Rights Reserved.</p>
    </footer>

    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
      integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"
      integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
