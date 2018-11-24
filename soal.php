<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
if (Login::isLoggedIn()){
    $title = 'Mengerjakan Soal - Tarung Soal';
    $content = '';
    $notif = '';
    $idUser = Login::isLoggedIn();
    if(isset($_POST['jawab'])){
        $jawabanbenar  = DB::query('SELECT jawaban FROM soal WHERE idSoal = :idSoal',array(':idSoal' => $_COOKIE['TSSI']))[0]['jawaban'];
        $hasil = $_COOKIE['TSSR'];
        if($jawabanbenar == $_POST['jawab']){
            $hasil ++;
        }
        setcookie("TSSR", $hasil, time() + 60 + 60 * 24 , '/', null, null, true);
        if(!isset($_COOKIE['TSS'])){
            setcookie("TSH",'-', time() + 60 * 60 * 24 , '/', null, null, true);      
            Login::redirect('./soal.php'); 
        }           
    }
    if(isset($_COOKIE['TSS'])){
        $arraysoal = json_decode(stripslashes($_COOKIE['TSS']));
        $idSoal = array_shift($arraysoal);
        setcookie("TSSI",$idSoal, time() + 60 + 60 , '/', null, null, true);
        rsort($arraysoal);
        //print_r($arraysoal);  Result is array 
        //echo '<br>'.$idSoal.'<br>'; Last Array
        $sisa = count($arraysoal);
        $jumlahSoal = $_COOKIE['TSC'];
        $nomor = $jumlahSoal - $sisa;
        $Soal = Content::JawabSoal($idSoal,$nomor);
        $content = Page::Title('Soal ke '.$nomor.' dari '.$jumlahSoal.'',$Soal);
        if($sisa == 0 || $sisa == NULL){
            setcookie("TSS",0, time() - 60 * 60 , '/', null, null, true);       
        }else{
            setcookie("TSS", json_encode($arraysoal),time()+60*60*24 , '/', null, null, true);
        }
    }
    if(isset($_COOKIE['TSH'])){
        $title = 'Hasil - Tarung soal';
        $hasil = $_COOKIE['TSSR'] / $_COOKIE['TSC'] * 100;
        DB::query('INSERT INTO hasil VALUES (\'\',:hasil,:poin,:jumlahsoal,:zip,:idUser,NOW())',array(':hasil'=>(int)$hasil,':poin'=>$_COOKIE['TSSR'],':jumlahsoal'=>$_COOKIE['TSC'],':zip'=>$_COOKIE['TSI'],':idUser'=>$idUser));
        $idHasil = DB::query('SELECT idHasil FROM hasil WHERE idUser = :idUser AND idZip = :zip ORDER BY idHasil DESC',array(':zip'=>$_COOKIE['TSI'],':idUser'=>$idUser))[0]['idHasil'];
        $content = Page::Title('Hasil Mengerjakan Soal',Content::HasilMengerjakanSoal($idHasil));
        setcookie("TSH",'-', time() - 60 * 60 * 24 , '/', null, null, true); 
        setcookie("TSSR",'-', time() - 60 + 60 * 24 , '/', null, null, true);
        setcookie("TSC", '-', time() - 60 + 60 * 24 , '/', null, null, true);
        setcookie("TSI_", '-', time() - 60 + 60 * 24 , '/', null, null, true);
        setcookie("TSST",$idHasil,time() + 60 + 60 * 24, '/', null, null, true);
    }elseif((isset($_COOKIE['TSST'])) && (!isset($_COOKIE['TSS']))){
        $title = 'Hasil - Tarung soal';
        $content = Page::Title('Hasil Mengerjakan Soal',Content::HasilMengerjakanSoal($_COOKIE['TSST']));
    }
    echo Page::DefaultPage($title,$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>  