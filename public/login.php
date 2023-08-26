<?php
$dsn = 'mysql:dbname=KUSO_SHOP;host=localhost';
$user = getenv("KUSO_USER");
$password = getenv("KUSO_PASS");

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    error_log($e->getMessage());
    die();
}
$email = filter_input(INPUT_POST, "email");
$password = filter_input(INPUT_POST, "password");
if ($email != null || $email != "") {
    $stmt = $dbh->prepare('SELECT CustomerID FROM Customer WHERE Email = ? AND DeleteDate= NULL');
    $stmt->bindValue(1, $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // ログイン試行回数をチェックする
    $stmt = $dbh->prepare('SELECT COUNT(*) FROM LoginAttempt WHERE CustomerID = ? AND AttemptTime > DATE_SUB(NOW(), INTERVAL 1 HOUR)');
    $stmt->bindValue(1, $user['CustomerID'], PDO::PARAM_INT);
    $stmt->execute();
    $attempt_count = $stmt->fetchColumn();
    if ($attempt_count >= 5) {
        // ログイン試行回数が制限を超えた場合
        echo "ログイン試行回数が制限を超えました。しばらくしてから再度お試しください。";
    } else {
        // ログイン処理を実行する
        $stmt = $dbh->prepare('SELECT CustomerID, PasswordHash FROM Password WHERE CustomerID = ? AND DeleteDate= NULL');
        $stmt->bindValue(1, $user['CustomerID'], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (isset($result['CustomerID']) && isset($result['PasswordHash'])) {
            if (password_verify($password, $result['PasswordHash'])) { //password_verifyはデフォルトでbcryptを使うらしい
                $_SESSION["CustomerID"] = $result['CustomerID'];
                $_SESSION["logged"] = true;
                session_regenerate_id();
                header("LOCATION: /");
            }
        }
        // ログインに失敗した場合、ログイン試行回数を記録する
        $stmt = $dbh->prepare('INSERT INTO LoginAttempt (CustomerID, AttemptTime) VALUES (?, NOW())');
        $stmt->bindValue(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        echo "ユーザー名かパスワードが違います";
    }
} else {
    require("loginUI.php");
}
