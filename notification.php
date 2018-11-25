<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
$idUser = Login::isLoggedIn();
if ($idUser != false){
    $title = 'Pesan - Tarung Soal';
    $notif = '';
    if(isset($_POST['simpan'])){
        $idKoleksi = $_POST['simpan'];
        DB::query('UPDATE koleksi SET statusKoleksi = :statusKoleksi WHERE idKoleksi = :idKoleksi',array(':idKoleksi'=>$idKoleksi,':statusKoleksi'=>1));
        $notif = "Pesan Disimpan";
    }
    if(isset($_POST['hapus'])){
        $idKoleksi = $_POST['hapus'];
        DB::query('DELETE FROM koleksi WHERE idKoleksi = :idKoleksi',array(':idKoleksi'=>$idKoleksi));
        $notif = "Pesan DiHapus";
    }
    $content1 = Content::PesanStatus(0);
    $content2 = Content::PesanStatus(1);
    $content3 = '';
    $content  = Page::BlockContent($content1,$content2,$content3);
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>  