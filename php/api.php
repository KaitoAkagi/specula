<?php
  /*+
  * データベースsenriganから取得したレコードをJSON形式で出力する。
  * 取得できない場合はエラー文を出力する
  *
  * @return json
  * @throws Exception
  * @throws Runtime Exception
  */

require "dbconnect.php";

session_start();

try {
    if (!isset($_GET["type"])) {
        throw new Exception("parameter is not defined");
    }

    switch ($_GET["type"]) {
        case "all_users":
            $stmt = exeSQL("SELECT * FROM ip_table WHERE 1 ORDER BY ip");
            break;
        case "same_server_user":
            $stmt = exeSQL("SELECT ip FROM ip_table WHERE name = '".$_SESSION["name"]."' ORDER BY ip");
            $same_ip = array();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $same_ip[] = "ip = '".$row["ip"]."'";
            }
            $same_ip = implode(' OR ', $same_ip);
            $stmt = exeSQL("SELECT * FROM ip_table WHERE ".$same_ip." ORDER BY ip");
            break;
        case "login_user":
            $stmt = exeSQL("SELECT * FROM ip_table WHERE name = '".$_SESSION["name"]."' ORDER BY ip");
            break;
        default:
            throw new RuntimeException("Invalid parameter");
        break;
    }

    $all_data = array();

    while ($rec = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $all_data[] = $rec;
    }
    header('Content-type:application/json; charset=utf8');

    echo json_encode($all_data, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo $e->getMessage();
}
