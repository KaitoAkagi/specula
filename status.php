<?php
  require "database.php";
  
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
  }
?>
