<?php
require "../../php/dbconnect.php";

session_start();

try {
    if (!isset($_POST["ip"])) {
        throw new Exception("Invalid Access");
    }

    // 送信されたnameの名前とipを取得
    $ip = htmlspecialchars($_POST["ip"]);
    $stmt = exeSQL("SELECT status FROM ip_table WHERE name = '".$_SESSION["name"]."' AND ip = '".$ip."'");
    $rec = $stmt->fetch(PDO::FETCH_BOTH);
    $status = $rec["status"];
    
    switch ($status) {
        case 0:
            $status = 1;
            break;
        case 1:
            $status = 0;
            break;
    }

    date_default_timezone_set('Asia/Tokyo');
    $time = date("Y/m/d H:i:s");
    $stmt = exeSQL("UPDATE ip_table SET status = '".$status."', time = '".$time."' WHERE name = '".$_SESSION["name"]."' AND ip = '".$ip."'");
} catch (Exception $e) {
    echo $e->getMessage();
}
