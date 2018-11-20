<?php   
class Login{
    public static function getNamaLengkapProfilLoggedIn(){
        if(isset($_COOKIE['TS_A'])){
            if (DB::query ('SELECT idLogin FROM login_token WHERE token=:token', array (':token' => sha1( $_COOKIE['TS_A'])))){
                $getIdProfil = self::getIdProfilLoggedIn();
                $namaLengkap = DB::query ('SELECT namaLengkap FROM user WHERE idUser = :idUser' , array('idUser'=>$getIdProfil))[0]['namaLengkap'];
                return $namaLengkap;
            }else return false;    
        }else false;
    }
    public static function getIdProfilLoggedIn(){
        if(isset($_COOKIE['TS_A'])){
            if (DB::query ('SELECT idLogin FROM login_token WHERE token=:token', array (':token' => sha1( $_COOKIE['TS_A'])))){
                $namaLengkap = DB::query ('SELECT namaLengkap FROM user, login_token WHERE user.idUser = login_token.idUser and token=:token', array (':token' => sha1( $_COOKIE['TS_A'])))[0]['namaLengkap'];
                $idUser = DB::query('SELECT idUser FROM login_token WHERE token=:token', array('token'=> sha1($_COOKIE['TS_A'])))[0]['idUser'];
                $idProfil = DB::query('SELECT user.idUser FROM user,login_token WHERE token=:token AND user.idUser = login_token.idUser', array('token'=> sha1($_COOKIE['TS_A'])))[0]['idUser'];
                return $idProfil;
            }else return false;
        }else return false;
    }   
    public static function isLoggedIn(){
        if (isset($_COOKIE['TS_A'])){
            if (DB::query ('SELECT idLogin FROM login_token WHERE token=:token', array (':token' => sha1( $_COOKIE['TS_A'])))){
                $idUser = DB::query('SELECT idUser FROM login_token WHERE token=:token', array('token'=> sha1($_COOKIE['TS_A'])))[0]['idUser'];
                
                if (isset($_COOKIE['TS_B'])){
                    return $idUser;
                } else {
                    $cstrong = true;
                    $token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
                    
                    DB::query('INSERT INTO login_token VALUES (\'\', :idUser, :token)', array(':token' => sha1($token), ':idUser'=>$idUser));
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
    public static function getGolongan(){
        $tokenparams = "";
        if(isset($_COOKIE['TS_A'])){
            $tokenparams = $_COOKIE['TS_A'];
        }else if(isset($_COOKIE['TS_C'])){
            $tokenparams = $_COOKIE['TS_C'];
        }
        $idUser = DB::query('SELECT idUser FROM login_token WHERE token=:token', array('token'=> sha1($tokenparams)))[0]['idUser'];
        $golongan = DB::query('SELECT idGologan FROM user WHERE idUser = :idUser',array(':idUser'=>$idUser))[0]['idGolongan'];
        return $golongan;
    }
    public static function redirect($location){
        header('Location: '.$location);
        die();
    }
    public static function erorr404(){
        self::redirect('./pages/samples/error-404.html');
    }
    public static function Dashboard(){
        self::redirect('./index.php');     
    }
}
?>