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
  <title>Cheese CMS | ニュース登録完了</title>
</head>
<body>
<div>
ニュースの登録が完了しました。
</div>
<div>
	<ul>
		<li><a href="index.php">Topに戻る</a></li>
	</ul>
</div>
</body>
</html>