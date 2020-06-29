<?php

    function exeSQL($sql){
        try {
            $dsn = 'mysql:dbname=specula;host=localhost';
            $username = 'root';
            $password = '17854tak03101112';
            $dbh = new PDO($dsn, $username, $password); //データベースに接続
            $dbh->query('SET NAMES utf8'); //文字コードのための設定
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $dbh = null; //データベースから切断
            return $stmt;
        } catch (Exception $e) {
            printf("<script>window.onload = function() {
                alert('サーバーに接続できません!');
                }</script>");
            echo $e -> getMessage();
        }
    }

?>