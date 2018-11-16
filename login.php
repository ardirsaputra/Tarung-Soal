<?php
    include('./classes/DB.php');
    include('./classes/Login.php');
    include('./classes/Log.php');
    include('./classes/Time.php');
    include('./classes/Navigation.php');
    $erorr = FALSE ;
    $notif ='';
    if(!Login::isLoggedIn()){
        if(isset($_COOKIE['TS_C'])){
                if(DB::query('SELECT idLogin FROM login_token WHERE token = :token ',array(':token' =>sha1($_COOKIE['TS_C'])))){
                    $idUser = DB::query('SELECT idUser FROM login_token WHERE token = :token ',array(':token' =>sha1($_COOKIE['TS_C'])))[0]['idUser'];
                    Log::logUserIn($idUser,Time::timeDatetime());
                    $token = sha1($_COOKIE['TS']);
                    setcookie("TS_A", $token, time() + 60 * 60 * 12, '/', null, null, true);
                    setcookie("TS_B", '1', time() + 60 * 60 * 12, '/', null, null, true);
                }    
        }   
        if (isset($_POST['login'])){
            if($_POST['email']!=''){
                if($_POST['password']!=''){
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    if (DB::query('SELECT email FROM user WHERE email=:email', array(':email'=>$email))){
                        $idUser = DB::query('SELECT idUser FROM user WHERE email=:email', array(':email'=> $email))[0]['idUser'];
                        if(password_verify($password,DB::query('SELECT passwordUser FROM user WHERE email=:email', array(':email'=>$email))[0]['passwordUser'])){
                            DB::loginUser($idUSer);
                            Login::Dashboard();    
                        }else $notif = "Password Salah";  
                    }else $notif = "Account tidak terdaftar";
                }else $notif =  'Password kosong';
            }else $notif = 'email kosong';
        }
        elseif(isset($_POST['create_account'])){
            if(isset($_POST['namaLengkap']) && isset($_POST['password'])){
                if(strlen($_POST['namaLengkap']) >= 4 and strlen($_POST['namaLengkap'])<=50){    
                    if(preg_match('/[a-zA-z ]+/',$_POST['namaLengkap'])){ 
                        $namaLengkap    = $_POST['namaLengkap'];
                        $email          = if($_POST['email'] != '') $_POST['email'] : '';
                        $tempatLahir    = if ($_POST['tempatLahir'] != '') $_POST['tempatLahir'] : '';
                        $tanggalLahir   = if ($_POST['tanggalLahir'] != '') $_POST['tanggalLahir'] : '';
                        $gender         = if ($_POST['gender'] != '') $_POST['gender'] : '' ; 
                        $alamat         = if ($_POST['alamat'] != '') $_POST['alamat'] : '';
                        $foto           = if ($_POST['tempatLahir'] != '') file_get_contents($_FILES['foto']['tmp_name']) : '';
                        $golongan       = if ($_POST['golongan'] != '') $_POST['golongan'] : '';
                        $password       = if ($_POST['password'] != '') $_POST['password'] : '';
                        $password2      = if ($_POST['password2'] != '') $_POST['password2'] : '';
                        DB::insertUser($namaLengkap,$email,$password,$golongan,$gender,$tempatLahir,$tanggalLahir,'',$foto);
                    }else $notif = 'Nama Lengkap tidak diperbolehkan';
                }else $notif = 'Panjang nama lengkap tidak diizinkan';
            }else $notif = 'Nama Lengkap dan Password Belum Diisi';
        }else{
            Page::LoginPage($notif);
        }
    }else{
        Login::Dashboard();
    }
?>