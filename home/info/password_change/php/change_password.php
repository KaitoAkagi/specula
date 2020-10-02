<?php

require "../../../../php/dbconnect.php";

session_start();

try {
    if (!isset($_POST['change'])) {
        throw new Exception("Invalid Access");
    }

    if (!isset($_POST["password"])) {
        throw new Exception("New password is empty");
    }

    $new_pwd = htmlspecialchars($_POST['password']);

    // パスワードをハッシュ値に変換してデータベースに保存
    if (!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $new_pwd)) {
        throw new Exception("Invalid Password");
    }
    $new_pwd = password_hash(htmlspecialchars($new_pwd), PASSWORD_DEFAULT);
    $stmt = exeSQL("UPDATE user_table SET password = '".$new_pwd."' WHERE name = '".$_SESSION["name"]."'");

    header("Location: ../../");
} catch (Exception $e) {
    echo $e->getMessage();
}
