<?php

require "../../php/dbconnect.php";

session_start();

try {
    if (!isset($_POST['register'])) {
        throw new Exception("Invalid Access");
    }

    if (!isset($_POST["ip"])) {
        throw new Exception("This IP address is empty");
    }

    if (!isset($_POST["name"])) {
        throw new Exception("This name is empty");
    }

    if (!isset($_POST["password"])) {
        throw new Exception("This password is empty");
    }

    $ip = htmlspecialchars($_POST['ip']);
    $name = htmlspecialchars($_POST['name']);
    $password = htmlspecialchars($_POST['password']);

    if (!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
        throw new Exception("This password is invalid");
    }

    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
    $stmt = exeSQL("SELECT name FROM user_table WHERE name='".$name."'");
        
    // 同じ名前のユーザーがいたらエラーメッセージ表示
    if ($stmt->fetch(PDO::FETCH_BOTH)) {
        throw new Exception("There is a user with the same name");
    }

    date_default_timezone_set('Asia/Tokyo');
    $time = date("Y/m/d H:i:s");

    // テーブル"user_table"に名前とパスワードを追加
    $stmt = exeSQL("INSERT INTO user_table (name,password) values ('".$name."','".$password."')");
    // テーブル"ip_table"に名前、ipと最終アクセス日時時間（time）を保存
    $stmt = exeSQL("INSERT INTO ip_table (name,ip,time) values ('".$name."','".$ip."','".$time."')");
    $_SESSION['name'] = $name;

    header("location: ../../home");
} catch (\Exception $e) {
    echo $e->getMessage();
    header("Location: ../incorrect.html");
}
