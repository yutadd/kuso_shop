<?php
session_start();
$dsn = 'mysql:dbname=KUSO_SHOP;host=localhost';
$_user = getenv("KUSO_USER");
$_password = getenv("KUSO_PASS");
if (!isset($_SESSION["CustomerID"])) {
    header("LOCATION: /login.php");
    echo $_SESSION["CustomerID"];
    exit();
}
try {
    $dbh = new PDO($dsn, $_user, $_password);
} catch (PDOException $e) {
    echo "サーバーでエラーが発生しました。";
    error_log($e->getMessage());
    die();
}
//データベースからユーザーのカート取得
$stmt = $dbh->prepare('SELECT Cart.ProductID, Product.ProductName, Cart.Count FROM Cart INNER JOIN Product ON Cart.ProductID = Product.ProductID WHERE Cart.CustomerID = ? AND CancelDate IS NULL');
$stmt->bindValue(1, $_SESSION["CustomerID"], PDO::PARAM_STR);
$stmt->execute();
?>
<table>
    <script type="module" src="static/module.js"></script>
    <tr>
        <th>product name</th>
        <th>個数</th>
    </tr>

    <?php //ユーザーのカートの中身一覧を表示。
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td><?php echo $row["ProductName"] ?></td>
            <td><input type="number" id="product<?php echo $row["ProductID"] ?>" name="count" value="<?php echo $row["Count"] ?>"></td>
            <td><button onclick="window.updateCart('<?php echo $row['ProductID'] ?>','<?php echo $row['ProductName'] ?>',document.getElementById(' <?php echo 'product' . $row['ProductID'] ?>'))">個数変更</button></td><!-- TODO -->
            <td><button onclick="window.deleteFromCart('<?php echo $row['ProductID'] ?>','<?php echo $row['ProductName'] ?>')">削除</button></td>
        </tr>
        <!--オーダーの情報と編集用のボタンを表示-->
    <?php } ?>
</table>