<?php
require_once '../conf/config.php';

// formから値を取得
$news_title = $_POST["news_title"];
$news_headline = $_POST["news_headline"];
$news_detail = $_POST["news_detail"];

// 入力文字数チェックを実装
if(mb_strlen($news_title) > 64){
    header('location: regist.php?error=title');
    exit;
}
if(mb_strlen($news_headline) > 128){
    header('location: regist.php?error=headline');
    exit;
}
if(mb_strlen($news_detail) > 1024){
    header('location: regist.php?error=detail');
    exit;
}

// SQLを実行し、データをインサート
$pdo = new PDO(DSN, DB_USER, DB_PASS);
// news_idについてはオートインクリメントのため、登録内容から除外するように修正
// news_headlineのスペルが間違っていたため修正
$stmt = $pdo->prepare("INSERT INTO cheese_news(
        news_title, news_headline, news_detail, update_date, create_date) VALUES (
        :news_title, :news_headline, :news_detail, sysdate(), sysdate())");

$stmt->bindValue(':news_title', $news_title);
$stmt->bindValue(':news_headline', $news_headline);
$stmt->bindValue(':news_detail', $news_detail);
$result = $stmt->execute();

// 失敗時はregist.php へリダイレクトするように修正
if(!$result) {
    header('location: regist.php?error=failregist');
    exit;
}

// register_complete.php へリダイレクト
header('location: register_complete.php');
exit;

?>
