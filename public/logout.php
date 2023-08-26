<?php
session_start();
$_SESSION["CustomerID"] = "";
$_SESSION["logged"] = false;
$_SESSION["email"] = "";
session_regenerate_id();
header("LOCATION: /");
