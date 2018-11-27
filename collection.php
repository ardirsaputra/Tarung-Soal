<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
$idUser = Login::isLoggedIn();
if ($idUser != false){
    $title = 'Koleksi Soal - Tarung Soal';
    $notif = '';
    $array = ['No','Judul Soal','Tingkat Soal','Tanggal Pembuatan'];
    $content = Page::Title('Koleksi Soal','<a href="./zip.php?tambahzip" class="btn btn-success form-control"><span class"fa fa-plus" aria-hidden="true">+</span>Soal</a>'.Page::List(Content::Headtable($array),Content::ListZip($idUser)));
    if(isset($_GET['msg'])){
        $notif = $_GET['msg'];
    }
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>  