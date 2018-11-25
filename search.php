<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
$idUser = Login::isLoggedIn();
if ($idUser != false){
    $title = 'Cari soal - Tarung Soal';
    $content = Content::CariSoal();
    $notif = '';
    if(isset($_POST['soal'])){
        $content1 = Page::Title('Hasil Pencarian "'.$_POST['soal'].'"',Content::HasilCariSoal($_POST['soal']));
        $content = Page::BlockContent($content,$content1,''); 
    }else{
        $content1 = Page::Title('Soal Terbaru',Content::SoalTerbaru());
        $content = Page::BlockContent($content,$content1,'');
    }
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>