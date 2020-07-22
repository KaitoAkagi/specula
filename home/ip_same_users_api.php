<?php
    require "../dbconnect.php";
    session_start();

    // ログインユーザーが所持するIPを全て取得
    $stmt = exeSQL("SELECT ip FROM ip_table WHERE name = '".$_SESSION["name"]."' ORDER BY ip");

    $same_ip = array();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($rows as $row){
        $same_ip[] = "ip = '".$row["ip"]."'";
    }
    
    $same_ip = implode(' OR ', $same_ip);

    $stmt = exeSQL("SELECT * FROM ip_table WHERE ".$same_ip." ORDER BY ip");

    // 全てのデータベースのデータを格納する配列を定義
    $all_data = array();
    
    //カラム名で配列に添字をつけた配列（連想配列）を返す
    while($rec = $stmt->fetch(PDO::FETCH_ASSOC)){
        $all_data[] = $rec;
    }
    
    //JSON_UNESCAPED_UNICODEは文字化け対策
    header('Content-type:application/json; charset=utf8');
    // JSON形式でレスポンスを返す
    echo json_encode($all_data, JSON_UNESCAPED_UNICODE);

?>