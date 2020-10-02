<?php

require "../../../../php/dbconnect.php";

session_start();

try {
    if (!isset($_POST["change"])) {
        throw new Exception("Invalid Access");
    }

    if (!isset($_POST["new_name"])) {
        throw new Exception("New name is empty");
    }

    $new_name = htmlspecialchars($_POST["new_name"]); //変更後のname
        
    // 2つのテーブルの名前を変更
    $stmt = exeSQL("UPDATE user_table SET name = '".$new_name."' WHERE name = '".$_SESSION["name"]."'");
    $stmt = exeSQL("UPDATE ip_table SET name = '".$new_name."' WHERE name = '".$_SESSION["name"]."'");

    $_SESSION["name"] = $new_name;

    header("Location: ../../index.html");
} catch (Exception $e) {
    echo $e->getMessage();
}
