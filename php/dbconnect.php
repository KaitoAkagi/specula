<?php

function exeSQL($sql)
{
    try {
        $dsn = 'mysql:dbname=specula;host=localhost';
        $username = 'admin';
        $password = 'adminpwd0246';
        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $dbh = null;
        return $stmt;
    } catch (PDOException $e) {
        printf('Error:'.$e->getMessage());
    }
}
