<?php

require "../../../php/dbconnect.php";

session_start();

try {
    if (!isset($_POST["delete"])) {
        throw new Exception("Invalid Access");
    }
    $name = htmlspecialchars($_SESSION["name"]);
    $stmt = exeSQL("DELETE FROM user_table WHERE name = '".$name."'");
    $stmt = exeSQL("DELETE FROM ip_table WHERE name = '".$name."'");
    header("Location: ../../php/logout.php");
} catch (Exception $e) {
    echo $e->getMessage();
}
