<?php
// セッションからログインステータスをチェック
session_start();

// 非ログイン時は、login.php へリダイレクト
if (!isset($_SESSION["STATUS"])) {
    header('location: login.php?error=notlogin');
}

require_once '../conf/config.php';

// index.phpからnews_idが渡ってくるので、取得
// 遷移元からGETでパラメータが渡されているため修正
$news_id = $_GET["news_id"];

// news_idに数値以外が入ってきたら、エラー
if(!is_numeric($news_id)) {
    header('location: index.php?error=news_id');
    exit;
}

// SQLを実行し、DBから該当idのデータを取得
$pdo = new PDO(DSN, DB_USER, DB_PASS);
$stmt = $pdo->prepare("SELECT * FROM cheese_news WHERE news_id = :news_id");
$stmt->bindParam(':news_id', $news_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// SQLの結果から、HTML出力用の変数を定義
$news_id = $result['news_id'];
$news_title = $result['news_title'];
$news_headline = $result['news_headline'];
$news_detail = $result['news_detail'];

// 取得したデータをformに埋め込む
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cheese CMS | ニュース更新</title>
</head>
<body>
<form method="post" action="update_execute.php">
<!-- news_idをフォーム内で保持するように修正-->
<input type="hidden" name="news_id" value="<?php echo $news_id ?>">;
<p>ニュースタイトル:<input type="text" name="news_title" size="64" value="<?php echo $news_title ?>"></p>
<p>ニュースヘッドライン:<input type="text" name="news_headline" size="128" value="<?php echo $news_headline ?>"></p>
<p>ニュース詳細</p>
<textarea name="news_detail" cols=128 rows=10><?php echo $news_detail ?></textarea>
<p><input type="submit" value="更新"></p>
</form>

<div>
    <ul>
        <li><a href="index.php">Topに戻る</a></li>
    </ul>
</div>
</body>
</html>
