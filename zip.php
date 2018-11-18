<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
if (Login::isLoggedIn()){
    $idUser = Login::isLoggedIn();
    $title = 'Buat soal - Tarung Soal';
    $content = Content::BuatSoal();
    $notif = '';
    if(isset($_POST['buatsoal'])){
        if($_POST['judul'] != ''){
            if($_POST['deskripsi'] != ''){
                if($_POST['idGolongan'] != ''){
                    if($_POST['startdate'] != '0000-00-00'){
                        $angkajam = strlen($_POST['starttime']);
                        if($angkajam == 1){
                            $jam = '0'.$_POST['starttime'];
                        }else{
                            $jam = $_POST['starttime'];
                        }
                        $start = $_POST['startdate'] .' '. $jam.':00:00';
                    }else $start = '0000-00-00 00:00:00';
                    if($_POST['finishdate'] != '0000-00-00'){
                        $angkajam2 = strlen($_POST['finishtime']);
                        if($angkajam2 == 1){
                            $jam2 = '0'.$_POST['finishtime'];
                        }else{
                            $jam2 = $_POST['finishtime'];
                        }
                        $finish = $_POST['finishdate'] .' '. $jam2.':00:00';
                    }else $finish = '0000-00-00 00:00:00';
                    if($_POST['passwordzip'] != ''){
                        $password = password_hash($_POST['passwordzip'],PASSWORD_BCRYPT);
                    }else $password = '';
                    $judul = $_POST['judul'];
                    $deskripsi = $_POST['deskripsi'];
                    $idGolongan = $_POST['idGolongan'];
                    DB::query('INSERT INTO zip VALUES(\'\',:judul,:deskripsi,:idGolongan,:starttime,:finishtime,NOW(),:passwordzip)',array(':judul'=>$judul,':deskripsi'=>$deskripsi,':idGolongan'=>$idGolongan,':starttime'=>$start,':finishtime'=>$finish,':passwordzip'=>$password));
                    $idZip = DB::query('SELECT idZip FROM zip WHERE judulZip =:judul AND deskripsiZip = :deskripsi AND idGolongan = :idGolongan ORDER BY idZip DESC ',array(':judul'=>$judul,':deskripsi'=>$deskripsi,':idGolongan'=>$idGolongan))[0]['idZip'];
                    Db::query('INSERT INTO user_zip VALUES (\'\',:idUser,:idZip)',array(':idUser'=>$idUser,':idZip'=>$idZip));
                    $notif = "Data soal telah dibuat";
                    Login::redirect('./zip.php?id='.$idZip.'&msg='.$notif.'');
                }else $notif ="Tingkat Soal Kosong";
            }else $notif ="Deskripsi kosong";
        }else $notif = "Judul kosong";    
    }
    if(isset($_GET['id'])){
        $idZip = $_GET['id'];
        $content = Content::Zip($idZip);
    }
    if(isset($_GET['msg'])){
        $notif = $_GET['msg']; 
    }
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>  