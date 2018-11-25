<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
$idUser = Login::isLoggedIn();
if ($idUser != false){
    $title = 'Buat soal - Tarung Soal';
    $notif = '';

    if(isset($_GET['tambahzip'])){
        $content = Page::Title('Buat Soal' , Content::BuatZip());
    }elseif(isset($_POST['buatsoal'])){
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
                        $password = $_POST['passwordzip'];
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
    }elseif(isset($_GET['id'])){
        $idZip = $_GET['id'];
        $title = 'Soal - Tarung Soal';
        $content = Page::Title('Data Soal',Content::Zip($idZip));
        if(isset($_POST['editzip'])){
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
                            $password = $_POST['passwordzip'];
                        }else $password = '';
                        $judul = $_POST['judul'];
                        $deskripsi = $_POST['deskripsi'];
                        $idGolongan = $_POST['idGolongan'];
                        DB::query('UPDATE zip SET 
                        judulZip = :judul,
                        deskripsiZip =  :deskripsi,
                        idGolongan = :idGolongan,
                        startZip = :starttime,
                        finishZip = :finishtime,
                        passwordZip = :passwordzip
                        WHERE
                        idZip =:idZip',
                        array(
                            ':idZip'=>$idZip,
                            ':judul'=>$judul,
                            ':deskripsi'=>$deskripsi,
                            ':idGolongan'=>$idGolongan,
                            ':starttime'=>$start,
                            ':finishtime'=>$finish,
                            ':passwordzip'=>$password));
                        $notif = "Update data soal berhasil";
                        Login::redirect('./zip.php?id='.$idZip.'&msg='.$notif.'');
                    }else $notif ="Tingkat Soal Kosong";
                }else $notif ="Deskripsi kosong";
            }else $notif = "Judul kosong";    
        }elseif(isset($_GET['ids'])){
            $idSoal = $_GET['ids'];
            if(isset($_POST['editsoal'])){
                if(isset($_POST['soal'])&& $_POST['soal'] != ''){
                    if(isset($_POST['jawaban']) && $_POST['jawaban']!= ''){
                        $soal = $_POST['soal'];
                        $jawabanA = $_POST['pilihana'];
                        $jawabanB = $_POST['pilihanb'];
                        $jawabanC = $_POST['pilihanc'];
                        $jawabanD = $_POST['pilihand'];
                        $jawaban = $_POST['jawaban'];
                        if(!empty($_FILES['foto']['tmp_name'])){
                            $foto = file_get_contents($_FILES['foto']['tmp_name']);
                            DB::query('UPDATE soal SET soal = :soal,jawabanA = :A ,jawabanB = :B,jawabanC = :C,jawabanD = :D,jawaban = :jawaban,foto = :foto WHERE idSoal = :idSoal ',array(':idSoal'=>$idSoal,':soal'=>$soal,':A'=>$jawabanA,':B'=>$jawabanB,':C'=>$jawabanC,':D'=>$jawabanD,':jawaban'=>$jawaban,':foto'=>$foto));
                        }else{
                            DB::query('UPDATE soal SET soal = :soal,jawabanA = :A ,jawabanB = :B,jawabanC = :C,jawabanD = :D,jawaban = :jawaban WHERE idSoal = :idSoal',array(':idSoal'=>$idSoal,':soal'=>$soal,':A'=>$jawabanA,':B'=>$jawabanB,':C'=>$jawabanC,':D'=>$jawabanD,':jawaban'=>$jawaban));
                        }
                        $content = Content::Zip($idZip);
                        $notif = 'Soal ID '.$idSoal.' berhasil diedit';
                    }
                }
            }elseif(isset($_GET['delete'])){
                DB::query('DELETE FROM zip_soal WHERE idSoal = :idSoal',array(':idSoal'=>$_GET['ids']));
                DB::query('DELETE FROM soal WHERE idSoal = :idSoal',array(':idSoal'=>$_GET['ids']));
                $notif = 'Hapus Soal id '.$_GET['ids'].' berhasil!';
                $content = Page::Title('Soal',Content::Zip($idZip));
            }elseif(isset($_GET['edit'])){
                $content = Page::Title('Edit Soal',Content::EditSoal($idZip,$idSoal));
            }
        }elseif(isset($_GET['edit'])){
            $content = Page::Title('Edit Data Soal',Content::ZipEdit($idZip));
        }elseif(isset($_POST['isisoal'])){
            if(isset($_POST['soal'])&& $_POST['soal'] != ''){
                if(isset($_POST['jawaban']) && $_POST['jawaban']!= ''){
                    $soal = $_POST['soal'];
                    $jawabanA = $_POST['pilihana'];
                    $jawabanB = $_POST['pilihanb'];
                    $jawabanC = $_POST['pilihanc'];
                    $jawabanD = $_POST['pilihand'];
                    $jawaban = $_POST['jawaban'];
                    $foto = '';
                    if(!empty($_FILES['foto']['tmp_name'])){
                        $foto = file_get_contents($_FILES['foto']['tmp_name']);
                    }else{
                        $foto = '';
                    }
                    DB::query('INSERT INTO soal VALUES (\'\',:soal,:A,:B,:C,:D,:jawaban,:foto)',array(':soal'=>$soal,':A'=>$jawabanA,':B'=>$jawabanB,':C'=>$jawabanC,':D'=>$jawabanD,':jawaban'=>$jawaban,':foto'=>$foto));
                    $idSoal = DB::query('SELECT idSoal FROM soal WHERE soal = :soal AND jawabanA = :jawabanA AND jawaban = :jawaban ORDER BY idSoal DESC',array(':soal'=>$soal, ':jawabanA'=>$jawabanA,':jawaban'=>$jawaban))[0]['idSoal'];
                    DB::query('INSERT INTO zip_soal VALUES (\'\',:idZip,:idSoal)',array(':idZip'=>$idZip,':idSoal'=>$idSoal));
                    $content = Page::Title('Data Soal',Content::Zip($idZip));
                    $notif = 'Soal berhasil dibuat';
                }
            }
        }elseif(isset($_POST['delete'])){
            if(DB::query('SELECT idZip FROM koleksi WHERE idZip =:idZip',array(':idZip'=>$idZip))){
                DB::query('DELETE FROM koleksi WHERE idZip =:idZip',array(':idZip'=>$idZip));
            }
            if(DB::query('SELECT idHasil FROM hasil WHERE idZip =:idZip',array(':idZip'=>$idZip))){
                DB::query('DELETE FROM hasil WHERE idZip =:idZip',array(':idZip'=>$idZip));
            }
            if(DB::query('SELECT idSoal FROM zip_soal WHERE idZip = :idZip',array(':idZip'=>$idZip))){
                $listSoal = DB::query('SELECT * FROM zip_soal WHERE idZip = :idZip',array(':idZip'=>$idZip));
                foreach($listSoal as $i){
                    DB::query('DELETE FROM zip_soal WHERE idSoal = :idSoal',array(':idSoal'=>$i['idSoal']));
                    DB::query('DELETE FROM soal WHERE idSoal = :idSoal',array(':idSoal'=>$i['idSoal']));
                }
            }
            DB::query('DELETE FROM user_zip WHERE idZip =:idZip',array(':idZip'=>$idZip));
            DB::query('DELETE FROM zip WHERE idZip =:idZip',array(':idZip'=>$idZip));
            Login::redirect('./collection.php?msg=Data soal terhapus');
        }elseif(isset($_GET['tambahsoal'])){
            $content  = Page::Title('Tambah Soal',Content::BuatSoal($idZip));
        }elseif(isset($_GET['deleteallsoal'])){
            if(DB::query('SELECT idSoal FROM zip_soal WHERE idZip = :idZip',array(':idZip'=>$idZip))){
                $listSoal = DB::query('SELECT * FROM zip_soal WHERE idZip = :idZip',array(':idZip'=>$idZip));
                foreach($listSoal as $i){
                    DB::query('DELETE FROM zip_soal WHERE idSoal = :idSoal',array(':idSoal'=>$i['idSoal']));
                    DB::query('DELETE FROM soal WHERE idSoal = :idSoal',array(':idSoal'=>$i['idSoal']));
                }
                $notif = "Hapus Semua Soal berhasil!";
                $content = Page::Title('Data Soal',Content::Zip($idZip));
            }else{
                $notif = "Soal belum ada!";
            }
        }elseif(isset($_POST['kerjakan'])){
            if(isset($_POST['passwordzip'])){
                $password = DB::query('SELECT passwordZip , finishZip FROM zip WHERE idZip = :idZip',array(':idZip'=>$idZip))[0];
                if($_POST['passwordzip'] == $password['passwordZip'] ){
                    $time = '';
                    $jumlahSoal = DB::query('SELECT count(idSoal) as Jumlah FROM zip_soal WHERE idZip = :idZip ',array(':idZip'=>$idZip))[0]['Jumlah'];
                    if($password['finishZip'] == '0000-00-00 00:00:00'){
                        $time = time() + 60 * 60 * 24 ; 
                    }else{
                        $time = strtotime($password['finishZip']);
                    }
                    $idSoal = [];
                    if(DB::query('SELECT idSoal FROM zip_soal WHERE idZip = :idZip',array(':idZip'=>$idZip))){
                        $dataSoal = DB::query('SELECT idSoal FROM zip_soal WHERE idZip = :idZip',array(':idZip'=>$idZip));
                        foreach ($dataSoal as $soal){
                            array_push($idSoal,$soal['idSoal']);
                        }
                    }else{
                        array_push($idSoal,'Kosong');    
                    }
                    print_r($idSoal);
                    setcookie("TSSR", 0, $time + 60 + 5 , '/', null, null, true);
                    setcookie("TSS", json_encode($idSoal), $time + 60 + 5 , '/', null, null, true);
                    setcookie("TSC", $jumlahSoal, $time + 60 + 5 , '/', null, null, true);
                    setcookie("TSI", $idZip, $time + 60 + 5 , '/', null, null, true);
                    setcookie("TSI_", $idZip , $time, '/', null, null, true);
                    
                    Login::redirect('./soal.php');
                }else{
                    $notif = 'Password Salah';
                }
            }else{
                $password = DB::query('SELECT passwordZip , finishZip FROM zip WHERE idZip = :idZip',array(':idZip'=>$idZip))[0];
                $time = '';
                $jumlahSoal = DB::query('SELECT count(idSoal) as Jumlah FROM zip_soal WHERE idZip = :idZip ',array(':idZip'=>$idZip))[0]['Jumlah'];
                if($password['finishZip'] == '0000-00-00 00:00:00'){
                    $time = time() + 60 * 60 * 24 ; 
                }else{
                    $time = strtotime($password['finishZip']);
                }
                
                $data = array();
                if(DB::query('SELECT idSoal FROM zip_soal WHERE idZip = :idZip',array(':idZip'=>$idZip))){
                    $dataSoal = DB::query('SELECT idSoal FROM zip_soal WHERE idZip = :idZip ORDER BY idSoal DESC',array(':idZip'=>$idZip));
                    foreach ($dataSoal as $soal){
                        $data  = array_push($soal['idSoal'],$data);
                    }
                }else{
                    $data = array('Kosong');    
                }
                setcookie("TSS", json_encode($data), $time + 60 + 5 , '/', null, null, true);
                setcookie("TSC", $jumlahSoal, $time + 60 + 5 , '/', null, null, true);
                setcookie("TSI", $idZip, $time + 60 + 5 , '/', null, null, true);
                setcookie("TSI_", $idZip , $time, '/', null, null, true);
                
                Login::redirect('./soal.php');  
            }
        }
    }else{
        Login::redirect('./collection.php?msg=Data soal belum dipilih');
    }
    if(isset($_GET['msg'])){
        $notif = $_GET['msg']; 
    }
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>  