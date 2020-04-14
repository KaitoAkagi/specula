<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> 削除 </title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<?php
		if (isset($_GET["name"])) {
			try {
				$dsn = 'mysql:dbname=server;host=localhost';
				$user = 'root';
				$password = '';
				$dbh = new PDO($dsn, $user, $password); //データベースに接続
				$dbh->query('SET NAMES utf8'); //文字コードのための設定

				$sql = "SELECT num,name FROM server_table WHERE 1";
				$stmt = $dbh->prepare($sql);
				$stmt->execute();
				$dbh = null; //データベースから切断
			} catch (Exception $e) {
				print 'サーバが停止しておりますので暫くお待ちください。';
				exit();
			}
			foreach ($stmt as $row) {
				if ($row['name'] == $_GET['name']) {
					print "<h2>以下の登録を削除しますか？</h2>";
					print "<table border=1 cellpadding=5>";
					print "<tr><th> サーバー名 </td><th> 登録名 </td></tr>";
					print "<tr>";
					printf("<td> %s </td>", $row["num"]);
					printf("<td> %s </td>", $row["name"]);
					print "</tr>";
					print "</table>";
					print "<br>";
				}
			}
		}

		if (isset($_POST['delete'])) {
			$name = $_GET['name'];
			try {
				$dsn = 'mysql:dbname=server;host=localhost';
				$user = 'root';
				$password = '';
				$dbh = new PDO($dsn, $user, $password); //データベースに接続
				$dbh->query('SET NAMES utf8'); //文字コードのための設定

				echo 'name:' . $name;
				$sql = "DELETE FROM server_table WHERE name = :name";
				$stmt = $dbh->prepare($sql);
				$data = array(':name' => $_GET['name']);
				var_dump($data);
				$stmt->execute($data);
				$dbh = null; //データベースから切断
				header("Location: index.php"); //削除作業後に利用者管理画面に戻る
				exit();
			} catch (Exception $e) {
				print 'サーバが停止しておりますので暫くお待ちください。';
				exit();
			}
		}
	?>
	<form method="post" action="">
		<input type="submit" name="delete" value="Yes">
		<input type="button" value="No" onClick="location.href='index.php'">
	</form>
</body>

</html>