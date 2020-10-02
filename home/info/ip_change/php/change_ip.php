<?php

require "../../../../php/dbconnect.php";

session_start();

try {
    if (!isset($_POST["add"])&&!isset($_POST["delete"])) {
        throw new Exception("Invalid Access");
    }

    if (isset($_POST["add"])) {
        $ip = htmlspecialchars($_POST["ip"]); //変更後のip

        // ipが空欄のまま追加ボタンを押した場合
        if (empty($ip)) {
            throw new Exception("Enter new IP address");
        }
        
        // テーブルip_tableにname,ipを追加
        $stmt = exeSQL("INSERT INTO ip_table (name,ip) values ('".$_SESSION["name"]."','".$ip."')");
    }

    if (isset($_POST["delete"])) {
        $ip = htmlspecialchars($_POST["ip"]); //削除するip

        // ipが空欄のまま削除ボタンを押した場合
        if (empty($ip)) {
            throw new Exception("Enter IP address which you want to delete");
        }
            
        // テーブルip_tableから指定した名前・ipアドレスを削除
        $stmt = exeSQL("DELETE FROM ip_table WHERE name = '".$_SESSION["name"]."' AND ip = '".$ip."' LIMIT 1");
    }

    header("Location: ../index.html");
} catch (Exception $e) {
    echo $e->getMessage();
}
