<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
if (Login::isLoggedIn()){
    $title = 'Dashboard - Tarung Soal';
    $content = Content::CariSoal().''.Page::Row(Content::Total('Jumlah Pengguna','user').''.Content::Total('Jumlah Data Soal','zip').''.Content::Total('Jumlah Soal','soal').''.Content::Total('Jumlah Pesan tersimpan','koleksi'));
    $array = ['Judul Soal','Tingkat','Pembuatan'];
    $zip = Page::Title('Koleksi Soal',Page::List(Content::Headtable($array),Content::ListZipDasboard()));
    $soaltersimpan = Page::Title('Pesan Tersimpan',Content::PesanDashboard());
    $content .= Page::Row(Content::CardLarge6($zip).''.Content::CardLarge6($soaltersimpan));
    $notif = '';
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>  