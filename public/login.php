<?php
session_start();
session_regenerate_id();
$dsn = 'mysql:dbname=KUSO_SHOP;host=localhost';
$_user = getenv("KUSO_USER");
$_password = getenv("KUSO_PASS");

try {
    $dbh = new PDO($dsn, $_user, $_password);
} catch (PDOException $e) {
    echo "サーバーでエラーが発生しました。";
    error_log($e->getMessage());
    die();
}
$email = filter_input(INPUT_POST, "email");
$password = filter_input(INPUT_POST, "password");
if ($email != null && $email != "") {
    $stmt = $dbh->prepare('SELECT CustomerID,Email FROM Customer WHERE Email = ? ');
    $stmt->bindValue(1, $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();
    if ($user != false) {
        $stmt = $dbh->prepare('SELECT COUNT(*) FROM LoginAttempt WHERE CustomerID = ? AND AttemptTime > DATE_SUB(NOW(), INTERVAL 2 MINUTE)');
        $stmt->bindValue(1, $user['CustomerID'], PDO::PARAM_INT);
        $stmt->execute();
        $attempt_count = $stmt->fetchColumn();
        // ログイン試行回数をチェックする
        if ($attempt_count >= 5) {
            // ログイン試行回数が制限を超えた場合
            echo "ログイン試行回数が制限を超えました。しばらくしてから再度お試しください。<br />";
            //TODO多数のログイン失敗があった旨をメール送信
        } else {
            // ログイン処理を実行する
            $stmt = $dbh->prepare('SELECT CustomerID, PasswordHash FROM Password WHERE CustomerID = ?');
            $stmt->bindValue(1, $user['CustomerID'], PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($result['CustomerID']) && isset($result['PasswordHash'])) {
                if (password_verify($password, $result['PasswordHash'])) { //password_verifyはデフォルトでbcryptを使うらしい
                    $_SESSION["CustomerID"] = $result['CustomerID'];
                    $_SESSION["email"] = $user['Email'];
                    $_SESSION["logged"] = true;
                    echo "loginに成功しました<br /><a href='/'>トップへ&gt;&gt;</a>";
                    exit();
                }
            }
        }
        // ログインに失敗した場合、ログイン試行回数を記録する
        $stmt = $dbh->prepare('INSERT INTO LoginAttempt (CustomerID, AttemptTime) VALUES (?, NOW())');
        $stmt->bindValue(1, $user['CustomerID'], PDO::PARAM_STR);
        $stmt->execute();
    }
    echo "ユーザー名かパスワードが違います";
}
require("loginUI.php");
