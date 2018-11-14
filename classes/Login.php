<?php
//include('./classes/Log.php');
//include('./classes/Time.php');
class Login{
    public static function getNamaLengkapProfilLoggedIn(){
        if(isset($_COOKIE['TS_A'])){
            if (DB::query ('SELECT idLogin FROM login_token WHERE token=:token', array (':token' => sha1( $_COOKIE['TS_A'])))){
                $getIdProfil = self::getIdProfilLoggedIn();
                $nama_lengkap = DB::query ('SELECT nama_lengkap FROM profil WHERE profil.idProfil = :idProfil' , array('idProfil'=>$getIdProfil))[0]['nama_lengkap'];
                return $nama_lengkap;
            }else return false;    
        }else false;
    }
    public static function getIdProfilLoggedIn(){
        if(isset($_COOKIE['TS_A'])){
            if (DB::query ('SELECT idLogin FROM login_token WHERE token=:token', array (':token' => sha1( $_COOKIE['TS_A'])))){
                $userName = DB::query ('SELECT username FROM user, login_token WHERE user.idUser = login_token.idUser and token=:token', array (':token' => sha1( $_COOKIE['TS_A'])))[0]['username'];
                $idUser = DB::query('SELECT idUser FROM login_token WHERE token=:token', array('token'=> sha1($_COOKIE['TS_A'])))[0]['idUser'];
                $idProfil = DB::query('SELECT user.idProfil FROM user,login_token WHERE token=:token AND user.idUser = login_token.idUser', array('token'=> sha1($_COOKIE['TS_A'])))[0]['idProfil'];
                return $idProfil;
            }else return false;
        }else return false;
    }   
    public static function isLoggedIn(){
        if (isset($_COOKIE['TS_A'])){
            if (DB::query ('SELECT idLogin FROM login_token WHERE token=:token', array (':token' => sha1( $_COOKIE['TS_A'])))){
                $userName = DB::query ('SELECT username FROM user, login_token WHERE user.idUser = login_token.idUser and token=:token', array (':token' => sha1( $_COOKIE['TS_A'])))[0]['username'];
                $idUser = DB::query('SELECT idUser FROM login_token WHERE token=:token', array('token'=> sha1($_COOKIE['TS_A'])))[0]['idUser'];
                
                if (isset($_COOKIE['TS_B'])){
                    return $idUser;
                } else {
                    $cstrong = true;
                    $token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
                    
                    DB::query('INSERT INTO login_token VALUES (\'\', :user_id, :token)', array(':token' => sha1($token), ':user_id'=>$idUser));
                    DB::query('DELETE FROM login_token WHERE token = :token', array(':token'=>sha1($_COOKIE['TS_A'])));
 
                    setcookie("TS_A", $token, time() + 60 * 60 * 12, '/', null, null, true);
                    setcookie("TS_B", '1', time() + 60 * 60 * 12, '/', null, null, true);

                    return $idUser;
                }    
            }   
        }else if(isset($_COOKIE['TS_C'])){
            if(DB::query('SELECT idLogin FROM login_token WHERE token = :token ',array(':token' =>sha1($_COOKIE['TS_C'])))){
                $idUser = DB::query('SELECT idUser FROM login_token WHERE token = :token ',array(':token' =>sha1($_COOKIE['TS_C'])))[0]['idUser'];
                Login::logUserIn($idUser,Login::timeDatetime());
                $token = sha1($_COOKIE['TS_C']);
                setcookie("TS_A", $token, time() + 60 * 60 * 12, '/', null, null, true);
                setcookie("TS_B", '1', time() + 60 * 60 * 12, '/', null, null, true);

                return $idUser;
            }    
        }
        return false;   
    }
    public static function getRole(){
        $tokenparams = "";
        if(isset($_COOKIE['TS_A'])){
            $tokenparams = $_COOKIE['TS_A'];
        }else if(isset($_COOKIE['TS_C'])){
            $tokenparams = $_COOKIE['TS_C'];
        }
        $idUser = DB::query('SELECT idUser FROM login_token WHERE token=:token', array('token'=> sha1($tokenparams)))[0]['idUser'];
        $role = DB::query('SELECT idRole FROM user WHERE idUser = :idUser',array(':idUser'=>$idUser))[0]['idRole'];
        return $role;
    }
    public static function redirect($location){
        header('Location: '.$location);
        die();
    }
    public static function erorr404(){
        self::redirect('./pages/erorr-404.html');
    }
}
?>
