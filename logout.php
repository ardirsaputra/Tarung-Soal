<?php 
include('classes/DB.php');
include('classes/Login.php');
include('classes/Log.php');
include('classes/Time.php');    
if(isset($_COOKIE['TS_A'])){
    $idUser = Login::isLoggedIn();
    Log::logUserOut($idUser,Time::timeDateHours());
    DB::query('DELETE FROM login_token WHERE token=:token', array(':token'=>sha1($_COOKIE['TS_A'])));
}
Login::redirect('./login.php');
?>