<?php
// セッションからログインステータスをチェック
session_start();

// 非ログイン時は、login.php へリダイレクト
if (!isset($_SESSION["STATUS"])) {
	header('location: login.php?error=notlogin');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cheese CMS | ニュース更新完了</title>
</head>
<body>
<div>
ニュース更新が完了しました。
</div>
<div>
	<ul>
		<li><a href="index.php">Topへ戻る</a></li>
	</ul>
</div>
</body>
</html>