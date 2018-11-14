<?php 
class Log{
    //for record user activity
    public static function logUserIn($idUser){
        DB::query('INSERT INTO log_user VALUES (\'\', :idUser, "Login" , \'\')', array( ':idUser'=>$idUser));

    }
    
    public static function logUserOut($idUser){
        DB::query('INSERT INTO log_user VALUES (\'\', :idUser, "Logout" , \'\')', array( ':idUser'=>$idUser));
    }

}
?>