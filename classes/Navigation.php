<?php
class Navigation {
    public static function makeAComboBox($name,$params,$choose){
        $combobox ='<select name="'.$name.'">';   
        if($choose!='' || $choose != NULL){
            foreach ($params as $i){
                if($choose == $i){
                    $combobox .='<option value="'.$i.'" selected>'.$i.'</option>';
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
        $idUser = Login::isLoggedIn();
        if(DB::query('SELECT * FROM user WHERE idUser = :idUser',array(':idUser'=>$idUser))){
            $foto = DB::query('SELECT foto FROM user WHERE idUser= :idUser',array(':idUser'=>$idUser))[0]['foto'];
            if($foto == ""){
                return './images/empty.jpg';
            }else{
                return './img.php?id='.$idUser.'';
            }
        }
        return false;
    }
    public static function getSourceImageProfil($idProfil){
        $foto = DB::query('SELECT foto FROM user WHERE idUser= :idUser',array(':idUser'=>$idProfil))[0]['foto'];
        if($foto == "" || $foto == NULL){
            return './images/empty.jpg';
        }else{
            return './img.php?id='.$idProfil.'';
        }
    }
    public static function getSourceImageSoal($idSoal){
        return './img.php?idSoal='.$idSoal.'';
    }
    public static function Header($title){
        return '
        <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>'.$title.'</title>
            <!-- plugins:css -->
            <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
            <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
            <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
            <!-- endinject -->
            <!-- plugin css for this page -->
            <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/font-awesome.css">
            <!-- End plugin css for this page -->
            <!-- inject:css -->
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/costum.css">
            <!-- endinject -->
            <link rel="shortcut icon" href="images/favicon.png" />
        </head>
        ';
    }
    public static function TimeSender($date){
        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");        
        
        date_default_timezone_set("Asia/Jakarta");
        $today = date("Y-m-d");
        $tahunNow = substr($today, 0, 4);               
        $bulanNow = substr($today, 5, 2);
        $tglNow   = substr($today, 8, 2);


        $tahun = substr($date, 0, 4);               
        $bulan = substr($date, 5, 2);
        $tgl   = substr($date, 8, 2);
        $jam   = substr($date, 10, 6);
        
        if(($tahunNow == $tahun)&&($bulanNow == $bulan )&&( $tglNow == $tgl )){
            $result = ''. $jam .'';
        }else{
            $result = $tgl . " " . $BulanIndo[(int)$bulan-1]. " ". $tahun;
        }
        return $result ;
        
    }
    public static function NavigationBar(){
        $dataNotifPesan = DB::query('SELECT * FROM koleksi WHERE statusKoleksi = 0 AND idPenerima = :idPenerima',array(':idPenerima'=>Login::isLoggedIn()));
        $countNotifPesan = 0;
        $listPesan ='';
        foreach($dataNotifPesan as $i ){
            $namaPegirim = DB::getNamaLengkap($i['idPengirim']);
            $fotoPofilPengirim = Navigation::getSourceImageProfil($i['idPengirim']);
            $waktuKirim = Navigation::TimeSender($i['createKoleksi']);
            $judul = DB::getJudulZip($i['idZip']);
            $listPesan .= '
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="'.$fotoPofilPengirim.'" alt="image"  class="img-xs rounded-circle profile-pic" >
                </div>
                <div class="preview-item-content flex-grow">
                    <h6 class="preview-subject ellipsis font-weight-medium text-dark">'.$namaPegirim.'
                        <span class="float-right font-weight-light small-text">'.$waktuKirim.'</span>
                    </h6>
                    <p class="font-weight-light small-text">
                       Mengirimkan Soal '.$judul.'
                    </p>
                </div>
            </a>
            ';
            $countNotifPesan++;
        }
        if($countNotifPesan != 0){
            $ifanypesan = '<a href="notification.php" ><span class="badge badge-info badge-pill float-right">Lihat Semua</span></a>'    ;                
            $infojumlahpesan = '<span class="count">'.$countNotifPesan.'</span>';
        }else{
            $infojumlahpesan = '';
            $ifanypesan ='';
        }
        return' 
        <div class="modal" id="search">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form class="forms-sample" action="./search.php" method="post">
                            <div class="form-group row">  
                                <div class="input-group col-sm-12">
                                    <input type="text" name="soal" class="form-control" placeholder="Cari Soal Disini" aria-label="Masukkan Nama" aria-describedby="colored-addon3">
                                    <div class="input-group-append bg-primary border-primary">
                                        <button class="btn btn-primary" type="submit">
                                            <span class="fa fa-search text-white"></span>
                                        </button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-times text-white"></span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a class="navbar-brand brand-logo" href="./">
                <img src="images/logo.png" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="./">
                <img src="./images/favicon2.png" alt="logo"/>
            </a>
        </div>

        <div class="navbar-menu-wrapper d-flex align-items-center">
            <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
                <li class="nav-item">
                    <a href="#search" class="text-white" data-toggle="modal" data-target="#search">
                        <span class="fa fa-search"> Cari Soal ...</span> 
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
                <!--Message notif on top-right-->
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="mdi mdi-file-document-box"></i>
                        '.$infojumlahpesan.'
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                        <div class="dropdown-item">
                            <p class="mb-0 font-weight-normal float-left">Kamu Memilik '.$countNotifPesan.' Kiriman Soal
                            </p>
                            '.$ifanypesan.'
                        </div>
                        '.$listPesan.'
                    </div>
                </li>
                <!--Notification on top-right side
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                        data-toggle="dropdown">
                        <i class="mdi mdi-bell"></i>
                        <span class="count">4</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                        <div class="dropdown-item">
                            <p class="mb-0 font-weight-normal float-left">Kamu Memilik 4 Notifikasi
                            </p>
                            <span class="badge badge-info badge-pill float-right">Lihat Semua</span>
                        </div>
                        
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="images/faces-clipart/pic-1.png" alt="image" class="profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow">
                                <h6 class="preview-subject ellipsis font-weight-medium text-dark">David Grey
                                    <span class="float-right font-weight-light small-text">10 Menit Yang Lalu</span>
                                </h6>
                                <p class="font-weight-light small-text">
                                    Telah Mengerjakan Soal dan Mendapat Nilai 70
                                </p>
                            </div>
                        </a>
                        
                    </div>
                </li>
                -->
                <!--User account top-right-->
                <li class="nav-item dropdown d-none d-xl-inline-block">
                    <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown"
                        aria-expanded="false">
                        <span class="profile-text">'.Login::getNamaLengkapProfilLoggedIn().'</span>
                        <img class="img-xs rounded-circle" src="'.Navigation::getSourceImageProfilLoggedIn().'" alt="Profile image">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <br>
                        <a class="dropdown-item" href="./user.php">
                            Biodata
                        </a>
                        <a class="dropdown-item" href="./rating.php">
                            Ratting </a>

                        <a class="dropdown-item" href="./collection.php">
                            Koleksi
                        </a>

                        <a class="dropdown-item" href="./setting.php">
                            Pengaturan
                        </a>
                        <a class="dropdown-item" href="./logout.php">
                            Keluar
                        </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
        </nav>';
    }
    public static function SideBar(){
        $idUser = Login::isLoggedIn();
        $dataNotifPesan = DB::query('SELECT idKoleksi FROM koleksi WHERE statusKoleksi = 0 AND idPenerima = :idPenerima',array(':idPenerima'=>$idUser));
        $countNotifPesan = 0;
        $listPesan ='';
        foreach($dataNotifPesan as $i ){
            $countNotifPesan++;
        }
        if($countNotifPesan != 0){
            $ifanypesan = '<a href="notification.php" ><span class="badge badge-info badge-pill float-right">Lihat Semua</span></a>'    ;                
            $infojumlahpesan = '<span class="count bg-primary text-white rounded p-1 img-xs">'.$countNotifPesan.'</span>';
        }else{
            $infojumlahpesan = '';
            $ifanypesan ='';
        }
        $listsoal = '';
        $datasoal = DB::query('SELECT idZip FROM user_zip WHERE idUser = :user ',array(':user'=>$idUser));
        if($datasoal != false){
            foreach($datasoal as $i){
                $judul =DB::getJudulZip($i['idZip']);
                if($judul >= 13 ){
                    $c = substr($judul,0,13).'...';
                }else{
                    $c = $judul;
                }
                $listsoal .= '
                <li class="">
                    <a class="nav-link" href="./zip.php?id='.$i['idZip'].'">
                        <i class="menu-icon mdi mdi-pencil"></i>
                        <span class="menu-title">'.$c.'</span>
                    </a>
                </li>
                ';
                
            }
        }else{
            $listsoal = '
            <li class="nav-item">
                <a class="nav-link" href="./zip.php?tambahzip">
                    <i class="menu-icon mdi mdi-pencil"></i>
                    <span class="menu-title">Tambah Judul Soal</span>
                </a>
            </li>
            ';
        }
        return '
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
            <li class="nav-item nav-profile">
                <div class="nav-link">
                    <div class="user-wrapper">
                        <div class="profile-image">
                            <img class="img-xs rounded-circle" src="'.Navigation::getSourceImageProfilLoggedIn().'" alt="profile image">
                        </div>
                        <div class="text-wrapper">
                            <p class="profile-name"><a href="./user.php?id='.Login::isLoggedIn().'">'.Login::getNamaLengkapProfilLoggedIn().'</a></p>
                            <div>
                                <small class="designation text-muted">Online</small>
                                <span class="status-indicator online"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./">
                    <i class="menu-icon mdi mdi-home"></i>
                    <span class="menu-title">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./search.php">
                    <i class="menu-icon fa fa-search"></i>
                    <span class="menu-title">Pencarian</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#datakoleksi" aria-expanded="false" aria-controls="datakoleksi">
                    <i class="menu-icon mdi mdi-content-copy"></i>
                    <span class="menu-title">Koleksi Soal</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="datakoleksi">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="./collection.php">
                                <i class="menu-icon fa fa-dropbox"></i>
                                <span class="menu-title">Koleksi</span>
                            </a>
                        </li>
                        '.$listsoal.'
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./record.php">
                    <i class="menu-icon fa fa-check-circle"></i>
                    <span class="menu-title">Data Hasil</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./notification.php">
                    <i class="menu-icon fa fa-stack-exchange"></i>
                    <span class="menu-title">Notifikasi   '.$infojumlahpesan.'</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./rating.php">
                    <i class="menu-icon fa fa-star"></i>
                    <span class="menu-title">Rating Ku</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./setting.php">
                    <i class="menu-icon fa fa-gears"></i>
                    <span class="menu-title">Pengaturan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./logout.php">
                    <i class="menu-icon fa fa-power-off"></i>
                    <span class="menu-title text-danger">Keluar</span>
                </a>
            </li>
        </ul>
        </nav>';
    }
    public static function DefaultJavaScript(){
        return ' <!-- plugins:js -->
        <script src="vendors/js/vendor.bundle.base.js"></script>
        <script src="vendors/js/vendor.bundle.addons.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page-->
        <!-- End plugin js for this page-->
        <!-- inject:js -->
        <script src="js/off-canvas.js"></script>
        <script src="js/misc.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="js/dashboard.js"></script>
        <!-- End custom js for this page-->';
    }
    public static function Footer(){
        return ' 
        <footer class="footer">
            <div class="container-fluid clearfix">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
                    <a href="http://www.zakaa.id/" target="_blank">Zakaa Studio</a>. All rights reserved.</span>
                <span class="float-none float-sm-right text-muted d-block mt-1 mt-sm-0 text-center">Pengembangan untuk Pendidikan Indonesia dari  
                <a href="https://codepen.io/ardiragilsaputra/full/yxoOOm/" target="_blank">Ars</a>
                </span>
            </div>
        </footer>';
    }
    public static function Time(){
        $list ='';
        for ($i = 0 ;$i <25 ;$i++){
            $list .= '<option value="'.$i.'">'.$i.'</option>';
        }
        return $list;
    }
    public static function DecodeTime($time){
        $date = substr($time, 0, 10); 
        $jam   = substr($time, 10, 3);
        return [$date,$jam] ;
    }
    public static function FormatDateIndo($date){
        $BulanIndo = array("","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");        
        $tahun = substr($date, 0, 4);               
        $bulan = substr($date, 5, 2);
        $tanggal = substr($date, 8, 2);
        $result = $tanggal." ".$BulanIndo[(int)$bulan]. " ". $tahun;
        if($bulan == "00"){
            return "Tidak ada";
        }
        return $result ;
    }
    public static function FormatDateHoursIndo($date){
        $BulanIndo = array("","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");        
        $tahun = substr($date, 0, 4);               
        $bulan = substr($date, 5, 2);
        $tanggal = substr($date, 8, 2);
        $jam   = substr($date, 10, 6);  
        $result = $jam." , ".$tanggal." ".$BulanIndo[(int)$bulan]. " ". $tahun;
        if($bulan == "00"){
            return "Tidak ada";
        }
        return $result ;
    }
}
?>