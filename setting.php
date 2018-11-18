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
    }elseif(isset($_POST['updateUser'])){
        if(isset($_POST['namaLengkap']) && strlen($_POST['namaLengkap']) >= 4 ){
            if(isset($_POST['email']) && $_POST['email']!=''){
                if(isset($_POST['idGolongan'])&& $_POST['idGolongan']!=''){
                    if(isset($_POST['nomorInduk'])&& $_POST['nomorInduk']!=''){
                        if(isset($_POST['sekolahUser'])&& $_POST['sekolahUser']!=''){
                        if(isset($_POST['gender'])&& $_POST['gender']!=''){
                            if(isset($_POST['tempatLahir'])&& $_POST['tempatLahir']!=''){
                                if(isset($_POST['tanggalLahir'])&& $_POST['tanggalLahir']!=''){
                                    $idUser = Login::isLoggedIn();
                                    $namaLengkap = $_POST['namaLengkap'];
                                    $email = $_POST['email'];
                                    $idGolongan = $_POST['idGolongan'];
                                    $nomorInduk = $_POST['nomorInduk'];
                                    $sekolahUser =$_POST['sekolahUser'];
                                    $gender = $_POST['gender'];
                                    $tempatLahir = $_POST['tempatLahir'];
                                    $tanggalLahir = $_POST['tanggalLahir'];
                                    $diskripsiUser = $_POST['deskripsiUser'];
                                    if(!empty($_FILES['foto']['tmp_name'])){
                                        $foto = file_get_contents($_FILES['foto']['tmp_name']);
                                    }
                                    if(!empty($_FILES['foto']['tmp_name'])){
                                        DB::query('UPDATE user SET 
                                        namaLengkap     = :namaLengkap,
                                        email           = :email,
                                        idGolongan      = :idGolongan ,
                                        nomorInduk      = :nomorInduk ,
                                        sekolahUser     = :sekolahUser,
                                        gender          = :gender,
                                        tempatLahir     = :tempatLahir, 
                                        tanggalLahir    = :tanggalLahir,
                                        foto            = :foto,
                                        diskripsiUser   = :diskripsiUser 
                                        WHERE 
                                        idUser          = :idUser',
                                        array(
                                        ':namaLengkap'  =>$namaLengkap,
                                        ':email'        =>$email,
                                        ':idGolongan'   =>$idGolongan,
                                        ':nomorInduk'   =>$nomorInduk,
                                        ':sekolahUser'  =>$sekolahUser,
                                        ':gender'       =>$gender,
                                        ':tempatLahir'  =>$tempatLahir,
                                        ':tanggalLahir' =>$tanggalLahir,
                                        ':foto'         =>$foto,
                                        ':diskripsiUser'=>$diskripsiUser,
                                        ':idUser'       =>$idUser 
                                    ));
                                    $notif = 'Pembaharuan data profil berhasil!';
                                    }else{
                                        DB::query('UPDATE user SET namaLengkap = :namaLengkap, email = :email ,idGolongan =:idGolongan ,nomorInduk =:nomorInduk,sekolahUser = :sekolahUser,gender = :gender, tempatLahir = :tempatLahir, tanggalLahir = :tanggalLahir, diskripsiUser = :diskripsiUser WHERE idUser = :idUser',array(':idUser' => $idUser ,':namaLengkap'=>$namaLengkap,':email'=>$email,':idGolongan'=>$idGolongan,':nomorInduk'=>$nomorInduk,':sekolahUser'=>$sekolahUser,':gender'=>$gender,':tempatLahir'=>$tempatLahir,':tanggalLahir'=>$tanggalLahir,':diskripsiUser'=>$diskripsiUser));
                                        $notif = 'Pembaharuan data profil berhasil!';
                                    }
                                }else $notif = 'Tanggal lahir harus ada';
                            }else $notif = 'Tempat lahir harus ada';
                        }else $notif = 'gender harus ada';
                        }else $notif = 'Sekolah harus ada';
                    }else $notif = 'Nomor induk harus ada';
                }else $notif = 'Pendidikan terakhir harus ada';
            }else $notif = 'Email harus ada';
        }else $notif = 'Nama Lengkap harus ada';
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