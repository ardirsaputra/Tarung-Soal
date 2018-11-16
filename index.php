<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
if (Login::isLoggedIn()){
    echo Page::DefaultPage('Dashboard - Tarung Soal','','');    
}else{
    Login::redirect('./login.php');
}
?>