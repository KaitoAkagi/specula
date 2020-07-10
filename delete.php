 <?php
      require "database.php";
        
      if (isset($_POST["id"])){
          $id = htmlspecialchars($_POST["id"]);
          $stmt = exeSQL("DELETE FROM user_table WHERE id = '".$id."'");
      }

      session_start();

      if (isset($_SESSION["id"])){
        $id = htmlspecialchars($_SESSION["id"]);
        $stmt = exeSQL("DELETE FROM user_table WHERE id = '".$id."'");
        header("Location: index.php");
      }

      // ログアウト処理
      header("Location: logout.php");

?>