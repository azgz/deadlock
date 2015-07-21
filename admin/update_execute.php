<?php
// セッションからログインステータスをチェック
session_start();

// 非ログイン時は、login.php へリダイレクト
if (!isset($_SESSION["STATUS"])) {
	header('location: login.php?error=notlogin');
}

//設定の読み込み
require_once '../conf/config.php';

// formから値を取得
$news_id = $_POST['news_id'];
$news_title = $_POST['news_title'];
$news_headline = $_POST['news_headline'];
$news_detail = $_POST['news_detail'];

// 入力チェックを実装
if(mb_strlen($news_title) > 64){
	header('location: update.php?error=title');
	exit;
}
if(mb_strlen($news_headline) > 128){
	header('location: update.php?error=headline');
	exit;
}
if(mb_strlen($news_detail) > 1024){
	header('location: update.php?error=detail');
	exit;
}

// SQLを実行し、データをアップデート
$pdo = new PDO(DSN, DB_USER, DB_PASS);
$stmt = $pdo->prepare('UPDATE cheese_news SET news_title = :news_title, news_headline = :news_headline, news_detail = :news_detail, update_date = sysdate() WHERE news_id=:news_id');

$stmt->bindValue(':news_id', $news_id);
$stmt->bindValue(':news_title', $news_title);
$stmt->bindValue(':news_headline', $news_headline);
$stmt->bindValue(':news_detail', $news_detail);
$result = $stmt->execute();

// update_complete.php へリダイレクト
header('location: update_complete.php');
exit;
?>