<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
if (Login::isLoggedIn()){
    $title = 'Dashboard - Tarung Soal';
    $content = Content::Dashboard();
    $notif = '';
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>  