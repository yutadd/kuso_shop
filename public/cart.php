<?php
$action = filter_input(INPUT_POST, "action");
if ($action === "add2Cart" || $action === "removeFromCart" || $action === "updateCart") {
    require_once("../components/add2Cart.php");
} elseif ($action == null) {
    require_once("../components/cartList.php");
}
