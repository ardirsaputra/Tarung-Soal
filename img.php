<?php
    include("./classes/DB.php");
    if(isset($_GET['id'])) {
        $img = DB::query("SELECT foto FROM user WHERE idProfil=:id",array(':id'=>$_GET['id']))[0];
        header("Content-type: image/png");
        echo $img["foto"];
    }elseif(isset($_GET['idSoal'])){
        $img = DB::query("SELECT foto FROM soal WHERE idSoal=:id",array(':id'=>$_GET['idSoal']))[0];
        header("Content-type: image/png");
        echo $img["foto"];
    }
?>