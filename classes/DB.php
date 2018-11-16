<?php
class DB {
    public static function connect(){
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=tarung_soal;charset=utf8','root','');
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public static function query($query,$param=array()){
        $statement = self::connect()->prepare($query);
        $statement->execute($param);
        if (explode(' ',$query)[0]=='SELECT'){
            $data = $statement->fetchAll();
            return $data;    
        }
    }
    public static function insertUser($namaLengkap,$email,$passwordUser,$idGolongan,$sekolahUser,$gender,$tempatLahir,$tanggalLahir,$deskripsiUser,$foto){
        self::query('INSERT INTO user VALUES (\'\',:namaLengkap,:email,:passwordUser,:idGolongan,:sekolahUser,:gender,:tempatLahir,:tanggalLahir,:deskripsiUser,:foto,\'\')',array(':namaLengkap'=>$namaLengkap,':email'=>$email,':passwordUser'=>password_hash($passwordUser,PASSWORD_BCRYPT),':idGolongan'=>$idGolongan,':sekolahUser'=>$sekolahUser,':gender'=>$gender,':tempatLahir'=>$tempatLahir,':tanggalLahir'=>$tanggalLahir,':deskripsiUser'=>$deskripsiUser,':foto'=>$foto));
    }
    public static function loginUser($idUser){
        $cstrong = true;
        $token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));    
        Log::logUserIn($idUser,Time::timeDateHours());
        DB::query('INSERT INTO login_token VALUES (\'\', :token, :idUser )', array(':token' => sha1($token), ':idUser'=>$idUser));          
        setcookie("TS_A", $token, time() + 60 * 60 * 12, '/', null, null, true);
        setcookie("TS_B", '1', time() + 60 * 60 * 12, '/', null, null, true);
    }
}
?>