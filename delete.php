 <?php
      require "database.php";
        
      if (isset($_POST["id"])){
          $id = htmlspecialchars($_POST["id"]);
          $stmt = exeSQL("DELETE FROM user_table WHERE id = '".$id."'");
      }
?>