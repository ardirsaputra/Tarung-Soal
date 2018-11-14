<?php
class Navigation {
    public static function makeAComboBox($name,$params,$choose){
        $combobox ='<select name="'.$name.'">';   
        if($choose!='' || $choose != NULL){
            foreach ($params as $i){
                if($choose == $i){
                    $combobox .='<option v  alue="'.$i.'" selected>'.$i.'</option>';
                }else{ 
                    $combobox .='<option value="'.$i.'">'.$i.'</option>';
                }
            }
        }else{
            foreach ($params as $i){
                $combobox .='<option value="'.$i.'">'.$i.'</option>';
            }
        }
        $combobox .='</select>';
        return $combobox;    
    }
    public static function getSourceImageProfilLoggedIn(){
        $idProfil = Login::getIdProfilLoggedIn();
        if(DB::query('SELECT * FROM profil WHERE idProfil = :idProfil',array(':idProfil'=>$idProfil))){
            $foto = DB::query('SELECT * FROM profil WHERE idProfil = :idProfil',array(':idProfil'=>$idProfil))[0]['foto'];
            if($foto = "" || $foto = NULL){
                return './images/faces-clipart/pic-1.png';
            }else{
                return './imageview.php?id='.$idProfil.'';
            }
        }
        return false;
    }
    public static function getSourceImageProfil($idProfil){
        return './imageview.php?id='.$idProfil.'';
    }
}
?>