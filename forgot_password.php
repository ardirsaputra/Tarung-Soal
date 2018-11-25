<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Navigation.php');
include('./classes/Content.php');
include('./classes/Page.php');
$idUser = Login::isLoggedIn();
if ($idUser == false){
    $notif = '';
    $content = Content::ForgotPassword();
    if(isset($_POST['forgotpassword'])){
        if(isset($_POST['email'])&&(isset($_POST['nomorInduk']))){
            if($_POST['email'] != '' || $_POST['nomorInduk'] =! ''){
                $email = $_POST['email'];
                $nomorInduk = $_POST['nomorInduk'];
                if(DB::query('SELECT idUser FROM user WHERE email =:email AND nomorInduk = :nomorInduk',array(':email'=>$email,':nomorInduk'=>$nomorInduk))){
                    $content = Content::FormPertanyaan($email,$nomorInduk);
                }else $notif = 'email atau nomor induk tidak diketahui';
            }else $notif = 'email atau nomorinduk kosong';
        }else $notif = 'email dan nomor induk';
    }elseif(isset($_POST['confirm'])){
        if(isset($_POST['id'])){
            if(isset($_POST['jawaban'])){
                $jawaban = Db::query('SELECT jawaban FROM forgot WHERE idUser = :idUser',array(':idUser'=>$_POST['id']))[0]['jawaban'];
                if($_POST['jawaban'] == $jawaban){
                    $content = Content::BuatPassword($_POST['id']);
                }else $notif = "Jawaban Salah";
            }else $notif = "jawaban tidak ada";
        }else $notif ="user tidak ditemukan";
    }elseif(isset($_POST['buatpassword'])){
        if(isset($_POST['id'])){
            if(isset($_POST['password'])&&isset($_POST['password2'])){
                if(strlen($_POST['password']) >= 8  && strlen($_POST['password2']) >= 8 ){
                    if($_POST['password'] == $_POST['password2'])  {
                        DB::query('UPDATE user SET passwordUser = :passwordUser WHERE idUser = :idUser',array(':passwordUser'=>password_hash($_POST['password'],PASSWORD_BCRYPT),':idUser'=>$_POST['id']));
                        Login::redirect('./login.php?msg');
                    }else {
                        $notif = "Password Tidak Sama";
                        $content = Content::BuatPassword($_POST['id']);
                    }
                }else{
                    $content = Content::BuatPassword($_POST['id']);
                    $notif ="Password tidak diizinkan";  
                } 
            }else{
                $content = Content::BuatPassword($_POST['id']);
                $notif ="Password baru tidak sama";
            }
        }else $notif = "User tidak diada";
    }
    //---------------------------------
    echo Page::LoginPage('Forgot Password - Tarung Soal',$notif,$content);    
}else{
    Login::Dashboard();
}
?>