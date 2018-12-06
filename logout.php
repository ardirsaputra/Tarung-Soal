<?php 
include('classes/DB.php');
include('classes/Login.php');
include('classes/Log.php');
include('classes/Time.php');    

if(isset($_GET['z'])){
    $idUser = Login::isLoggedIn();
    DB::query('DELETE FROM login_token WHERE idUser = :idUser', array(':idUser'=>$idUser));
    setcookie("TS_A", '-', time() - 60 * 60, '/', null, null, true);
               
}elseif(isset($_COOKIE['TS_A'])){
    $idUser = Login::isLoggedIn();
    Log::logUserOut($idUser,Time::timeDateHours());
    if(DB::query('SELECT idLogin FROM login_token WHERE token=:token', array(':token'=>sha1($_COOKIE['TS_A'])))){
        DB::query('DELETE FROM login_token WHERE token=:token', array(':token'=>sha1($_COOKIE['TS_A'])));
    }
}
Login::redirect('./login.php');
?>