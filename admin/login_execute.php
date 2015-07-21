<?php
session_start();

require_once '../conf/config.php';

// formから値を取得
$mail      = $_POST["mail"];
$password  = $_POST["password"];

// SQLを実行し、e-mail, パスワードが一致するレコードがあるかチェック
$pdo = new PDO(DSN, DB_USER, DB_PASS);
// 既存のSQLでは下記要因により速度が遅くなるかと思います。
//  ・登録内容全件に対してチェックした上で、結果を返してるため、登録件数が増えた場合に時間を要する。
//  ・対象テーブルはインデックスが貼られていないため検索に時間を要する。
// 対応としてレコードの存在確認だけであれば、取得項目を指定した上でLIMIT またはEXISTS句を使用した方が速くなります。
$stmt = $pdo->prepare("SELECT COUNT(email) FROM cheese_admin_user
        WHERE email = :email AND password = :password
        LIMIT 1");

$stmt->bindValue(':email', $mail);
$stmt->bindValue(':password', $password);
$stmt->execute();
$count = $stmt->fetchColumn();

// 失敗時はlogin.php へリダイレクト
if($count != 1) {
    header('location: login.php?error=faillogin');
    exit;
}

// 成功時はセッションにログイン情報をセット
$_SESSION["STATUS"] = "OK";

// index.php へリダイレクト
header('location: index.php');
exit;
?>
