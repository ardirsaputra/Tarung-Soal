<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
if (Login::isLoggedIn()){
    $idUser = Login::isLoggedIn();
    $title = 'Data Hasil - Tarung Soal';
    $content = Page::Title('Data Hasil',Content::HasilZip($idUser));
    $notif = '';
    
    if(isset($_GET['id'])){
        if(DB::query('SELECT idZip FROM user_zip WHERE idUser = :idUser AND idZip =:idZip',array(':idUser'=>$idUser,':idZip'=>$_GET['id']))){
            $content = Page::Title('Data Hasil'.PHP_EOL.''.DB::getJudulZip($_GET['id']).'',Content::ListHasilZip($_GET['id']));
            if(isset($_GET['idh'])){
                if(isset($_GET['d'])){
                    $nama = DB::getNamaLengkap(DB::query('SELECT idUser FROM hasil WHERE idHasil = :idHasil',array(':idHasil'=>$_GET['idh']))[0]['idUser']);
                    DB::query('DELETE FROM hasil WHERE idHasil = :idHasil',array(':idHasil'=>$_GET['idh']));
                    $content = Page::Title('Data Hasil'.PHP_EOL.''.DB::getJudulZip($_GET['id']).'',Content::ListHasilZip($_GET['id']));
                    $notif = 'Penghapusan hasil dari pengguna '.$nama.' berhasil !';
                }
            }
        }
    }
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>  