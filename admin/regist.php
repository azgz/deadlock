<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cheese CMS | ニュース登録</title>
</head>
<body>
<form method="post" action="register_execute.php">
<p>ニュースタイトル:<input type="text" name="news_title" size="64"></p>
<p>ニュースヘッドライン:<input type="text" name="news_headline" size="128"></p>
<p>ニュース詳細</p>
<textarea name="news_detail" cols=128 rows=10></textarea>
<p><input type="submit" value="登録"></p>
</form>

<div>
	<ul>
		<li><a href="index.php">Topに戻る</a></li>
	</ul>
</div>
</body>
</html>