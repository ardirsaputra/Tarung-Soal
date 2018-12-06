<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
$idUser = Login::isLoggedIn();
if ($idUser != false){
    $title = 'User - Tarung Soal';
    $notif = '';
    $content1 = '';
    $content2 = '';
    $content3 = '';
    if(isset($_GET['id'])){
        $idPenerima = $_GET['id'];
        if(isset($_POST['reviewuser'])){
            $rating = $_POST['rating'];
            $review = $_POST['review'];
            DB::query('INSERT INTO rating VALUES (\'\',:jenisItem,:idPenerima,:nilai,:review,:idUser,0)',
            array(':jenisItem'=>'User',':idPenerima'=>$idPenerima,':nilai'=>$rating,':review'=>$review,':idUser'=>$idUser));
            $notif = 'Memberikan review berhasil dikirim';
        }elseif(isset($_POST['editreviewuser'])){
            if(isset($_POST['r'])){
                $rating = $_POST['rating'];
                $review = $_POST['review'];
                $idHasil = $_POST['r'];
                DB::query('UPDATE rating SET nilaiRating = :nilai,komentarRating = :review WHERE idHasil = :r)',
                array(':nilai'=>$rating,':review'=>$review,':r'=>$idHasil));
                $notif = 'Edit review berhasil';
            }
        }
        $content1 = Page::Title('Biodata '.DB::getNamaLengkap($idPenerima).'',Content::UserView($idPenerima));
        $content2 = Page::Title('Review',Content::ReviewUser($idPenerima));   
        $array = ['No','Judul Soal','Tingkat Soal','Tanggal Pembuatan'];
        $content3 = Page::Title('Daftar Soal',Page::List(Content::Headtable($array),Content::ListZip($idPenerima))); 
        if($idUser == $_GET['id']){
            $content1 ='';
            $content2 = Page::Title('Biodata Anda',Content::UserView($idUser)); 
            $content3 = Page::Title('Daftar Soal',Page::List(Content::Headtable($array),Content::ListZip($idPenerima))); 
        }elseif(isset($_GET['idz'])) {
            if(DB::query('SELECT idZip FROM user_zip WHERE idZip = :idZip AND idUser =:idUser',array(':idZip'=>$_GET['idz'],':idUser'=>$idUser))){
                $content2 = Page::Title('Kirim Soal',Content::TombolKirim($idPenerima,$_GET['idz']));
                $content3 ='';
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
        $content1 = Page::Title('Cari Penerima',Content ::SearchUser($idZip));
        if(isset($_POST['nama'])){
            $namaLengkap = $_POST['nama'];
            $content2 = Page::Title('Hasil Pencarian',Content :: ListUser($namaLengkap,$idZip));
        }
    }else{
        $content1 = Page::Title('Biodata Anda',Content::UserView($idUser)); 
    }
    $content = Page::BlockContent($content1,$content2,$content3);
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>