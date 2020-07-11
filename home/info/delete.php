 <?php
      require "../../database.php";

      session_start();

      if (isset($_SESSION["name"])){
        $name = htmlspecialchars($_SESSION["name"]);
        $stmt = exeSQL("DELETE FROM user_table WHERE name = '".$name."'");
        $stmt = exeSQL("DELETE FROM ip_table WHERE name = '".$name."'");
        header("Location: ../logout.php");
      }

?>