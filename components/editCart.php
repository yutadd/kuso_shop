<?php

/**
 * カートの登録、編集、削除。
 * 尚updateCartはオーダー完了後は受け付けない。
 */
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
$id = filter_input(INPUT_POST, "productID") === null ? die("ID wasn' set a value") : filter_input(INPUT_POST, "productID");
$count = filter_input(INPUT_POST, "count") === null ? die("count wasn' set a value") : filter_input(INPUT_POST, "count");


if (true) {
    //$actionがadd2Cart
    if (is_string($id) && is_int($count)) {
        //もしすでに同じIDの商品が登録されている場合はcountを指定分増加、データベースに登録する
    }
} elseif (false) {
    //$actionがremoveFromCart
} else {
    //$actionがupdateCart
}
