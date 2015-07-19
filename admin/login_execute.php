<?php
session_start();

require_once '../conf/config.php';

// formから値を取得
$mail      = $_POST["mail"];
$password  = $_POST["password"];

// SQLを実行し、e-mail, パスワードが一致するレコードがあるかチェック
$pdo = new PDO(DSN, DB_USER, DB_PASS);
$stmt = $pdo->prepare("SELECT COUNT(*) FROM cheese_admin_user 
		WHERE email = :email AND password = :password");

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