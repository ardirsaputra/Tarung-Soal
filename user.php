<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
if (Login::isLoggedIn()){
    $idUser = Login::isLoggedIn();
    $title = 'Dashboard - Tarung Soal';
    $content1 = '';
    $content2 = '';
    $content3 = '';
    if(isset($_GET['id'])){
        $idPenerima = $_GET['id'];
        $content1 = Content::UserView($idPenerima);
        if($idUser == $_GET['id']){
            $content1 = Content::UserView($idUser);    
        }elseif(isset($_GET['idz'])) {
            if(DB::query('SELECT idZip FROM user_zip WHERE idZip = :idZip AND idUser =:idUser',array(':idZip'=>$_GET['idz'],':idUser'=>$idUser))){
                $content2 = Content::TombolKirim($idPenerima,$_GET['idz']);
                if(isset($_POST['kirimsoal'])){
                    $keterangan = $_POST['keterangan'];
                    $idPengirim = $idUser ;
                    $idZip = $_GET['idz'];
                    DB::query('INSERT INTO koleksi VALUES(\'\',:idPenerima,:idPengirim,:idZip,:keterangan,0,NOW())',array(':idPenerima'=>$idPenerima,':idPengirim'=>$idPengirim,':idZip' => $idZip,':keterangan'=>$keterangan));
                    $notif = 'Soal telah Terkirim kepada '.DB::getNamaLengkap($idPenerima).'';
                    Login::redirect('./collection.php?msg='.$notif.'');
                }
            }else{
                Login::erorr404();
            }
        }
    }elseif(isset($_GET['idz'])){
        $idZip = $_GET['idz'];
        $content1 = Content ::SearchUser($idZip);
        if(isset($_POST['nama'])){
            $namaLengkap = $_POST['nama'];
            $content2 = Content :: ListUser($namaLengkap,$idZip);
        }
    }else{
        $content1 = Content::UserView($idUser);    
    }
    $notif = '';
    $content = Page::BlockContent($content1,$content2,'');
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>