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
        $foto = DB::query('SELECT foto FROM ser WHERE idUser= :idUser',array(':idUser'=>$idProfil))[0]['foto'];
        if($foto = "" || $foto = NULL){
            return './images/profil.jpg';
        }else{
            return './img.php?id='.$idProfil.'';
        }
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
            <!-- End plugin css for this page -->
            <!-- inject:css -->
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/costum.css">
            <!-- endinject -->
            <link rel="shortcut icon" href="images/favicon.png" />
        </head>
        ';
    }
    public static function NavigationBar(){
        return' <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a class="navbar-brand brand-logo" href="index.html">
                <img src="images/logo.png" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="index.html">
                <img src="'.self::getSourceImageProfilLoggedIn().'" alt="logo" />
            </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">

            <ul class="navbar-nav navbar-nav-right">
                <!--Message notif on top-right-->
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="mdi mdi-file-document-box"></i>
                        <span class="count">2</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                        <div class="dropdown-item">
                            <p class="mb-0 font-weight-normal float-left">Kamu Memilik 2 Kiriman Soal
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
                                    Telah Mengirimkan Soal A
                                </p>
                            </div>
                        </a>
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
                                    Telah Mengirimkan Soal B
                                </p>
                            </div>
                        </a>
                    </div>
                </li>
                <!--Notification on top-right side-->
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
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="images/faces-clipart/pic-1.png" alt="image" class="profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow">
                                <h6 class="preview-subject ellipsis font-weight-medium text-dark">David Grey
                                    <span class="float-right font-weight-light small-text">5 Menit Yang Lalu</span>
                                </h6>
                                <p class="font-weight-light small-text">
                                    Telah Mengerjakan Soal dan Mendapat Nilai 80
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="images/faces-clipart/pic-1.png" alt="image" class="profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow">
                                <h6 class="preview-subject ellipsis font-weight-medium text-dark">David Grey
                                    <span class="float-right font-weight-light small-text">1 Menit Yang Lalu</span>
                                </h6>
                                <p class="font-weight-light small-text">
                                    Telah Mengerjakan Soal dan Mendapat Nilai 90
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="images/faces-clipart/pic-1.png" alt="image" class="profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow">
                                <h6 class="preview-subject ellipsis font-weight-medium text-dark">David Grey
                                    <span class="float-right font-weight-light small-text">10 Detik Yang Lalu</span>
                                </h6>
                                <p class="font-weight-light small-text">
                                    Telah Mengerjakan Soal dan Mendapat Nilai 100
                                </p>
                            </div>
                        </a>
                    </div>
                </li>
                <!--User account top-right-->
                <li class="nav-item dropdown d-none d-xl-inline-block">
                    <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown"
                        aria-expanded="false">
                        <span class="profile-text">'.Login::getNamaLengkapProfilLoggedIn().'</span>
                        <img class="img-xs rounded-circle" src="'.Navigation::getSourceImageProfilLoggedIn().'" alt="Profile image">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <br>
                        <a class="dropdown-item">
                            Biodata
                        </a>
                        <a class="dropdown-item">
                            Ratting </a>

                        <a class="dropdown-item">
                            Koleksi
                        </a>

                        <a class="dropdown-item">
                            Pengaturan
                        </a>
                        <a class="dropdown-item">
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
        return '
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
            <li class="nav-item nav-profile">
                <div class="nav-link">
                    <div class="user-wrapper">
                        <div class="profile-image">
                            <img src="'.Navigation::getSourceImageProfilLoggedIn().'" alt="profile image">
                        </div>
                        <div class="text-wrapper">
                            <p class="profile-name">'.Login::getNamaLengkapProfilLoggedIn().'</p>
                            <div>
                                <small class="designation text-muted">Online</small>
                                <span class="status-indicator online"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./index.php">
                    <i class="menu-icon mdi mdi-television"></i>
                    <span class="menu-title">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./colection.php">
                    <i class="menu-icon mdi mdi-television"></i>
                    <span class="menu-title">Koleksi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./datasoal.php">
                    <i class="menu-icon mdi mdi-backup-restore"></i>
                    <span class="menu-title">Soal</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./record.php">
                    <i class="menu-icon mdi mdi-bookmark-plus-outline"></i>
                    <span class="menu-title">Hasil</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./send.php">
                    <i class="menu-icon mdi mdi-sticker"></i>
                    <span class="menu-title">Kirim Soal</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./setting.php">
                    <i class="menu-icon mdi mdi-restart"></i>
                    <span class="menu-title">Pengaturan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./logout.php">
                    <i class="menu-icon mdi mdi-restart"></i>
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
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with
                <i class="mdi mdi-heart text-danger"></i>
                </span>
            </div>
        </footer>';
    }
}
?>