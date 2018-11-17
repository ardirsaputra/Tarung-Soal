<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
if (Login::isLoggedIn()){
    $idUser = Login::isLoggedIn();
    $notif = '';
    //---------------------------------
    if(isset($_POST['setPassword'])){
        if((isset($_POST['oldPassword']))&&(isset($_POST['newPassword']))&&(isset($_POST['matchNewPassword']))){
            $password = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $matchNewPassword = $_POST['matchNewPassword'];
            if(password_verify($password,DB::query('SELECT passwordUser FROM user WHERE idUser=:idUser', array(':idUser'=>$idUser))[0]['passwordUser'])){
                if($newPassword == $matchNewPassword){
                    if(strlen($newPassword) >=8 and strlen($newPassword) <=60){
                        DB::query('UPDATE user SET passwordUser=:passwordUser WHERE idUser=:idUser',array(':passwordUser'=>password_hash($newPassword,PASSWORD_BCRYPT),':idUser'=>$idUser));
                        $notif = "Password berhasil diganti !";
                    }else $notif =  "Password Salah" ;
                }else $notif = "password tidak sama ";
            }else $notif = "Password lama salah";
        }else $notif = "ada borang yang kosong";
    }elseif(isset($_POST['forgotpassword'])){
        if(isset($_POST['pertanyaan'])){
            if(isset($_POST['jawabaan'])){
                 DB::query('INSERT INTO forgot VALUES ( \'\',:idUser,:pertanyaan,:jawabaan)',array(':idUser'=>$idUser,':pertanyaan'=>$_POST['pertanyaan'],':jawabaan'=>$_POST['jawabaan']));
                 $notif = "Menambah Pengaturan Lupa Password Berhasil";
            }
        }
    }elseif(isset($_POST['updaterecovery'])){
        if(isset($_POST['idrecovery'])){
            if(isset($_POST['pertanyaan'])){
                if(isset($_POST['jawaban'])){
                     DB::query('UPDATE forgot SET pertanyaan = :pertanyaan , jawaban = :jawaban WHERE idForgot = :idForgot)',array(':idForgot'=>$_POST['idrecovery'],':pertanyaan'=>$_POST['pertanyaan'],':jawaban'=>$_POST['jawaban']));
                     $notif = "Mengubah Pengaturan Lupa Password Berhasil";
                }else $notif = "Jawaban tidak ada";
            }else $notif ="Pertanyaan tidak ada";
        }else $notif = "Lupa id user";
    }
    //---------------------------------
    $profil = Content::profil($idUser);
    $password = Content::password($idUser);
    $recovery = Content::passwordRecovery();
    $content = Page::Setting($profil,$password,$recovery);
    echo Page::DefaultPage('Setting - Tarung Soal',$notif,$content);    
}else{
    Login::redirect('./login.php');
}
?>