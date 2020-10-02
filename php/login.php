<?php

require "dbconnect.php";

session_start();

// ログインボタンを押した後の処理
try {
    if (!isset($_POST["name"])) {
        throw new Exception("This name is empty");
    }

    if (!isset($_POST["password"])) {
        throw new Exception("This password is empty");
    }
    $name = htmlspecialchars($_POST["name"]);
    $stmt = exeSQL("SELECT * FROM user_table WHERE name = ?");
    $stmt->execute([$name]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!isset($row['name'])) {
        throw new Exception("The name is not find");
    }

    $password = htmlspecialchars($_POST["password"]);

    if (!password_verify($password, $row['password'])) {
        throw new Exception("Incorrect password");
    }

    session_regenerate_id(true);
    $_SESSION['name'] = $row['name'];
    $_SESSION['id'] = $row['id'];
    header("Location: ../home");
} catch (\Exception $e) {
    echo $e->getMessage();
    header("Location: ../incorrect.html");
}
