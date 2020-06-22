<?php
    try {
        $dsn = 'mysql:dbname=dus_system;host=localhost';
        $username = 'root';
        $password = '17854tak03101112';
        $dbh = new PDO($dsn, $username, $password); //データベースに接続
        $dbh->query('SET NAMES utf8'); //文字コードのための設定
        $sql = "SELECT * FROM user_table WHERE 1 ORDER BY ip";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $dbh = null; //データベースから切断

        $all_data = array();
        
        //カラム名で配列に添字をつけた配列を返す
        while($rec = $stmt->fetch(PDO::FETCH_ASSOC)){
            $all_data[] = $rec;
        }
        
        //JSON_UNESCAPED_UNICODEは文字化け対策
        header('Content-type:application/json; charset=utf8');
        $json = json_encode($all_data, JSON_UNESCAPED_UNICODE);
        echo $json;

    } catch (Exception $e) {
        printf("<script>window.onload = function() {
            alert('サーバーに接続できません!');
            }</script>");
        echo $e -> getMessage();
    }
?>