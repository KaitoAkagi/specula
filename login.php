<?php

    require "database.php";

    session_start();

    //DB内でPOSTされたメールアドレスを検索
    try {
        $stmt = exeSQL("SELECT * FROM user_table WHERE name = ?");
        $stmt->execute([$_POST["name"]]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }

    //emailがDB内に存在しているか確認
    if (!isset($row['name'])) {
        header("Location: index.php");
        return false;
        echo ' <script>alert("名前またはパスワードが間違っています")</script>';
    }

    //パスワード確認後sessionにメールアドレスを渡す
    if (password_verify($_POST['password'], $row['password'])) {
        session_regenerate_id(true); //session_idを新しく生成し、置き換える
        $_SESSION['name'] = $row['name'];
        header("Location: table.php");
    } else {
        echo ' <script>alert("名前またはパスワードが間違っています")</script>';
        return false;
    }

?>