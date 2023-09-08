<?php
session_start();
/**
 * カートの登録、編集、削除。
 * 尚updateCartはオーダー完了後は受け付けない。
 */
$dsn = 'mysql:dbname=KUSO_SHOP;host=localhost';
$_user = getenv("KUSO_USER");
$_password = getenv("KUSO_PASS");
$action = filter_input(INPUT_POST, "action");
function responseError($code, $reason)
{
    http_response_code($code);
    die($reason);
}
try {
    $dbh = new PDO($dsn, $_user, $_password);
} catch (PDOException $e) {

    responseError(400, "サーバーでエラーが発生しました。");
    error_log($e->getMessage());
    die();
}

if ($action === "add2Cart") {
    $customerID = $_SESSION["CustomerID"];
    $id = is_numeric(filter_input(INPUT_POST, "productID")) ? filter_input(INPUT_POST, "productID") : responseError(400, "ID wasn' provided");
    $count = is_numeric(filter_input(INPUT_POST, "count")) ? filter_input(INPUT_POST, "count") : responseError(400, "count wasn' provided");
    //$actionがadd2Cart
    if ($count > 0) {
        $stmt = $dbh->prepare('SELECT ProductID,Count FROM Cart WHERE CustomerID=? and CancelDate IS NULL');
        $stmt->bindValue(1, $customerID, PDO::PARAM_INT);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["ProductID"] == $id) {
                responseError(400, "あなたはすでに同じ商品をカートに追加されています。");
            }
        }
        $stmt = $dbh->prepare('INSERT INTO Cart(CustomerID,ProductID,Count) VALUES(?,?,?)');
        $stmt->bindValue(1, $customerID, PDO::PARAM_INT);
        $stmt->bindValue(2, $id, PDO::PARAM_INT);
        $stmt->bindValue(3, $count, PDO::PARAM_INT);
        $stmt->execute();
        echo "データを登録したよ！";
    } else {
        responseError(400, "個数が不正です");
    }
}elseif($action==="updateCart"){
    $customerID = $_SESSION["CustomerID"];
    $id = is_numeric(filter_input(INPUT_POST, "productID")) ? filter_input(INPUT_POST, "productID") : responseError(400, "ID wasn' provided");
    $count = is_numeric(filter_input(INPUT_POST, "count")) ? filter_input(INPUT_POST, "count") : responseError(400, "count wasn' provided");
    //$actionがadd2Cart
    if ($count > 0) {
        $stmt = $dbh->prepare('SELECT count(ProductID) AS total FROM Cart WHERE CustomerID=? AND ProductID=? and CancelDate IS NULL');
        $stmt->bindValue(1, $customerID, PDO::PARAM_INT);
        $stmt->bindValue(2, $id, PDO::PARAM_INT);
        $stmt->execute();
        $already=$stmt->fetch(PDO::FETCH_ASSOC)["total"];
            if ($already==1) {
                $stmt = $dbh->prepare('UPDATE Cart SET Count=? WHERE CustomerID=? AND ProductID=? and CancelDate IS NULL');
                $stmt->bindValue(1, $count, PDO::PARAM_INT);
                $stmt->bindValue(2, $customerID, PDO::PARAM_INT);
                $stmt->bindValue(3, $id, PDO::PARAM_INT);
                $stmt->execute();
                echo "データを書き換えしたよ！";
            }else{
            responseError(500,"カートに2つ以上同じ商品が登録されています。管理者にお問い合わせください。\r\ncode:".$already[0]);
            }
    } else {
        responseError(400, "個数が不正です");
    }
} elseif ($action === "removeFromCart") {
    $customerID = $_SESSION["CustomerID"];
    $id = is_numeric(filter_input(INPUT_POST, "productID")) ? filter_input(INPUT_POST, "productID") : responseError(400, "ID wasn' provided");
    //$actionがremoveFromCart
    $stmt = $dbh->prepare('SELECT count(ProductID) AS total FROM Cart WHERE CustomerID=? and CancelDate IS NULL');
    $stmt->bindValue(1, $customerID, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->fetch(PDO::FETCH_ASSOC)["total"] > 0) {
        $stmt = $dbh->prepare('UPDATE  Cart SET CancelDate=? WHERE CustomerID=? AND ProductID=? and CancelDate IS NULL');
        $date = new DateTime('now');
        $stmt->bindValue(1, $date->getTimestamp(), PDO::PARAM_STR);
        $stmt->bindValue(2, $customerID, PDO::PARAM_INT);
        $stmt->bindValue(3, $id, PDO::PARAM_INT);
        $stmt->execute();
        echo "カートから削除しました";
    } else {
        responseError(400, "指定された商品IDはあなたのカートに存在しません");
    }
} else {
    responseError(400, "invalid action");
    //$actionがupdateCart
}