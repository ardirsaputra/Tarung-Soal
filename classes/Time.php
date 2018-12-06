<?php
class Time {
    //current DATETIME in database    
    public static function timeDateHours(){
        date_default_timezone_set("Asia/Jakarta");
        $timeNow = date("Y-m-d h:i:s");   
        return $timeNow;
    }
    //current DATE in database
    public static function timeDate(){
        date_default_timezone_set("Asia/Jakarta");
        $timeNow = date("Y-m-d");
        return $timeNow;   
    }
}
?>