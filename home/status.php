<?php
  require "../database.php";
  
  session_start();

  if (isset($_POST["ip"])) {
    // 送信されたnameの名前とipを取得
    $ip = htmlspecialchars($_POST["ip"]);
    $stmt = exeSQL("SELECT status FROM ip_table WHERE name = '".$_SESSION["name"]."' AND ip = '".$ip."'");
    $rec = $stmt->fetch(PDO::FETCH_BOTH);
    $status = $rec["status"];
    
    if($status == 0) $status = 1;
    else $status = 0;

    date_default_timezone_set('Asia/Tokyo'); //東京の日付に合わせる
    $time = date("Y/m/d H:i:s");
    $stmt = exeSQL("UPDATE ip_table SET status = '".$status."', time = '".$time."' WHERE name = '".$_SESSION["name"]."' AND ip = '".$ip."'");
  }
?>