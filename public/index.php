<?php
session_start();
function isLoggedIn()
{
    if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
        return true;
    } else {
        return false;
    }
}
echo "<h1>kuso shop</h1>";
if (isLoggedIn()) {
    require_once("../components/loggedin.php");
} else {
    require_once("../components/notLoggedin.php");
}
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
$stmt = $dbh->prepare('SELECT ProductID,ProductName,Price,Description FROM product WHERE DeleteDate IS NULL');
$stmt->execute();
?>

<table>
    <script type="module" src="static/module.js"></script>

    <tr>
        <th>Product img</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Description</th>
    </tr>
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td>
                <script>
                    window.caller<?php echo $row['ProductID'] ?>= function() {
                        window.add2Cart(<?php echo $row['ProductID'] ?>, <?php echo $row['ProductName'] ?>);
                    }
                </script>
            </td>
            <td><img src=<?php echo "static/" . $row['ProductName'] . ".webp" ?> width="300px" ; alt=""></td>
            <td><?php echo $row['ProductID']; ?></td>
            <td><?php echo $row['ProductName']; ?></td>
            <td><?php echo "\\" . $row['Price']; ?></td>
            <td><?php echo $row['Description']; ?></td>
            <td><button type="button" id="addproduct" onclick="javascript:window.caller()">購入</button></td>
        </tr>
    <?php } ?>
</table>