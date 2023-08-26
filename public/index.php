<?php 
session_start();
function isLoggedIn(){
    if(isset($_SESSION["logged"])&&$_SESSION["logged"]==true){
        return true;
    }else{
        return false;
    }
}
echo "<h1>HackMeIfYouCan</h1>";
if(isLoggedIn()){
    require_once("loggedin.php");
}else{
    require_once("notLoggedin.php");
}
