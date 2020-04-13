<html>
<head>
<meta charset="UTF-8">
<title> BisLab Server </title>
</head>
<body>
<h3> User list </h3>
<?php
try{
	$dsn = 'mysql:dbname=server;host=localhost';
	$user = 'root';
	$password = '';
	$dbh = new PDO($dsn, $user, $password); //データベースに接続
	$dbh->query('SET NAMES utf8'); //文字コードのための設定
	
	$sql = "SELECT num,name FROM server_table WHERE 1 ORDER BY num";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$dbh = null; //データベースから切断
	print "使用者リスト<BR>";
	print "<table border=1 cellpadding=5>";
	print "<tr>";
	printf("<th> サーバー名 </td>");
    printf("<th> 登録名 </td>");
	printf("<th> 編集 </th>");
	printf("<th> 削除 </th>");
	print "</tr>";
	
	while(true){
		$rec=$stmt->fetch(PDO::FETCH_BOTH);
		if($rec==false) break;
		print "<tr>";
		printf("<td> %s </td>", $rec["num"]);
		printf("<td> %s </td>", $rec["name"]);
		printf ("<td><input type=\"button\" value=\"編集\" onClick=\"location.href='edit.php?name=%s'\"></td>", $rec["name"]);
		printf("<td><input type=\"button\" value=\"削除\" onClick=\"location.href='delete.php?name=%s'\"></td>", $rec["name"]);		
		print "</tr>";
	}
	print "</table>";
}
catch(Exception $e){
	print 'サーバが停止しておりますので暫くお待ちください。';
	exit();	
}
?>

<br>
<input type="button" value="新規登録" onClick="location.href='register.php'">
<input type="button" value="使用状況" onClick="location.href='status.php'">

</body>
</html>