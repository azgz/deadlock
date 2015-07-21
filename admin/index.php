<?php
// セッションからログインステータスをチェック
session_start();

// 非ログイン時は、login.php へリダイレクト
if (!isset($_SESSION["STATUS"])) {
    header('location: login.php?error=notlogin');
}

require_once '../conf/config.php';

// ログイン時は、SQLを実行し、DBから一覧を取得
$pdo = new PDO(DSN, DB_USER, DB_PASS);
$stmt = $pdo->prepare("SELECT * FROM cheese_news ORDER BY create_date DESC LIMIT 5");
$stmt->execute();
$view = "";

// SQLの結果から、HTMLを生成
while ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $news_id = $result['news_id'];
    // 特殊文字チェックを追加
    $news_title = htmlspecialchars($result['news_title'], ENT_QUOTES);
    $news_headline = htmlspecialchars($result['news_headline'], ENT_QUOTES);
    $news_detail = htmlspecialchars($result['news_detail'], ENT_QUOTES);
    $update_date = htmlspecialchars($result['update_date'], ENT_QUOTES);
    $create_date = htmlspecialchars($result['create_date'], ENT_QUOTES);
    $view .= '<ul><li>'. $news_id . '</li><li>'. $news_title . '</li><li>' . $news_headline . '</li><li>'
            // </li>が余分なため修正
            . $news_detail . '</li><li>' . $update_date . '</li><li>'
            // 遷移先へのパラメータキーを修正
            . $create_date . '</li><li><a href="update.php?news_id=' . $news_id . '">更新</a></li></ul>';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cheese CMS | 管理画面Top</title>
</head>
<body>
<h2>Cheese CMS | 管理画面Top</h2>
<div>
    <ul>
        <li>ニュースid</li>
        <li>ニュースタイトル</li>
        <li>ニュースヘッドライン</li>
        <li>ニュース詳細</li>
        <li>更新時間</li>
        <li>登録時間</li>
    </ul>
    <!-- データベースの取得結果はここで表示 -->
    <?php echo $view ?>
</div>
<div>
    <ul>
        <li><a href="regist.php">ニュースを登録する</a></li>
    </ul>
</div>
</body>
</html>
