<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
$idUser = Login::isLoggedIn();
if ($idUser != false){
    $title = 'Dashboard - Tarung Soal';
    $content = Content::CariSoal().''.Page::Row(Content::Total('Jumlah Pengguna','user').''.Content::Total('Jumlah Judul Soal','zip').''.Content::Total('Jumlah Soal','soal').''.Content::Total('Jumlah Peserta Soal','hasil'));
    $array = ['Judul Soal','Tingkat','Pembuatan'];
    $zip = Page::Title('Koleksi Soal',Page::List(Content::Headtable($array),Content::ListZipDasboard()));
    $content .= Page::Row(Content::CardLarge6($zip).'');
    $notif = '';
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>  