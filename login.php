<?php
    include('./classes/DB.php');
    include('./classes/Login.php');
    include('./classes/Log.php');
    include('./classes/Time.php');
    include('./classes/Navigation.php');
    include('./classes/Page.php');
    include('./classes/Content.php');
    $erorr = FALSE ;
    $notif ='';
    if(Login::isLoggedIn()){
        Login::Dashboard();
    }else{
        if(isset($_POST['login'])){
            if($_POST['email']!=''){
                if($_POST['password']!=''){
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    if (DB::query('SELECT email FROM user WHERE email=:email', array(':email'=>$email))){
                        $idUser = DB::query('SELECT idUser FROM user WHERE email=:email', array(':email'=> $email))[0]['idUser'];
                        if(password_verify($password,DB::query('SELECT passwordUser FROM user WHERE email=:email', array(':email'=>$email))[0]['passwordUser'])){
                            DB::loginUser($idUser);
                            Login::redirect('./index.php');    
                        }else $notif = "Password Salah";  
                    }else $notif = "User tidak terdaftar";
                }else $notif =  'Password kosong';
            }else $notif = 'email kosong';
        }elseif(isset($_POST['create_account'])){
            if(isset($_POST['namaLengkap']) && isset($_POST['password'])){
                if(strlen($_POST['password']) >= 4 and strlen($_POST['password'])<=50){    
                    if(strlen($_POST['namaLengkap']) >= 4 and strlen($_POST['namaLengkap'])<=50){    
                        if(preg_match('/[a-zA-z ]+/',$_POST['namaLengkap'])){ 
                            if(preg_match('/[0-9]+/',$_POST['nomorInduk'])){ 
                                $namaLengkap    = $_POST['namaLengkap'];
                                $email          = ($_POST['email'] != '' )?$_POST['email'] : '';
                                $tempatLahir    = ($_POST['tempatLahir'] != '')?$_POST['tempatLahir'] : '';
                                $tanggalLahir   = ($_POST['tanggalLahir'] != '')?$_POST['tanggalLahir'] : '';
                                $gender         = ($_POST['jk'] != '')?$_POST['jk'] : '' ; 
                                $foto           = '';
                                $nomorInduk     = $_POST['nomorInduk'];
                                $golongan       = ($_POST['idgolongan'] != '')?$_POST['idgolongan'] : '';
                                $sekolahUser    = ($_POST['sekolahUser'] != '')?$_POST['sekolahUser'] : '';
                                $password       = ($_POST['password'] != '')?$_POST['password'] : '';
                                $password2      = ($_POST['password2'] != '')?$_POST['password2'] : '';
                                DB::insertUser($namaLengkap,$email,$password,$golongan,$nomorInduk,$sekolahUser,$gender,$tempatLahir,$tanggalLahir,'',$foto);
                                $idUser = DB::query('SELECT idUser FROm user WHERE namaLengkap = :namaLengkap AND email =:email AND tempatLahir = :tempatLahir ORDER BY idUser DESC',array(':namaLengkap'=> $namaLengkap ,':email'=>$email, ':tempatLahir' => $tempatLahir))[0]['idUser'];
                                DB::loginUser($idUser);
                                Login::redirect('./index.php');
                            }else $notif = 'Nomor induk Harus Angka' ;
                        }else $notif = 'Nama Lengkap tidak diperbolehkan';
                    }else $notif = 'Panjang nama lengkap tidak diizinkan';
                }else $notif = "Password tidak diizinkan";
            }else $notif = 'Nama Lengkap dan Password belum diisi';
        }
    }
    $content = Content::Login();
    echo Page::LoginPage('Tarung Soal',$notif,$content);    
?>