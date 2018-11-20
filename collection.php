<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
if (Login::isLoggedIn()){
    $idUser = Login::isLoggedIn();
    $title = 'Koleksi Soal - Tarung Soal';
    $notif = '';
    $array = ['No','Judul Soal','Tingkat Soal','Tanggal Pembuatan','<a href="./zip.php" class="btn btn-success"><span class"fa fa-plus" aria-hidden="true">+</span>Soal</a>'];
    $content = Page::List(Content::Headtable($array),Content::ListZip($idUser));
    if(isset($_GET['msg'])){
        $notif = $_GET['msg'];
    }
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>  