<?php 
    class Page{
        public static function DefaultPage($title,$notif,$content){
            return '
            <!DOCTYPE html>
            <html lang="en">
            '.Navigation::Header($title).'
            <body>
                <div class="container-scroller">
                    <!-- partial:partials/_navbar.html -->
                    '.Navigation::NavigationBar().'
                    <!-- partial -->
                    <!--The body start here-->
                    <div class="container-fluid page-body-wrapper">
                        <!-- partial:partials/_sidebar.html -->
                        '.Navigation::SideBar().'
                        <!-- partial -->
                        <!--The Main Panel-->
                        <div class="main-panel">
                            <span class="bg-warning">
                            '.$notif.'
                            </span>
                            <div class="content-wrapper">
                            '.$content.'
                            </div>
                            '.Navigation::Footer().'
                            <!-- partial -->
                        </div>
                        <!-- main-panel ends -->
                    </div>
                    <!-- page-body-wrapper ends -->
                </div>
                <!-- container-scroller -->

               '.Navigation::DefaultJavaScript().'
            </body>

            </html>
            ';
        }
        public static function LoginPage($title,$notif){
            $golongan = DB::query('SELECT * FROM golongan');
            $listGolongan= '';
            foreach($golongan as $i ){
                $listGolongan.= "<option value=".$i['idGolongan'].">".$i['namaGolongan']."</option>";
            }
            if($notif !=''){
                $n = '<div class="row"><span class="bg-warning col-md-12 rounded  text-center text-bold text-light">
                '.$notif.'
                </span>
                </div>';
            }else{
                $n ='';
            }
            return '
            <!DOCTYPE html>
            <html lang="en">
            '.Navigation::Header($title).'
            <body>
                <div class="container-scroller">
                    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
                        <div class="content-wrapper d-flex align-items-center auth auth-bg-2 theme-one">
                            <div class="col-lg-4 col-sm-10 mx-auto">
                                <div class="auto-form-wrapper">
                                    '.$n.'
                                    <div class="logo-login">
                                        <img src="./images/Logo.png" class="img-fluid">
                                    </div>
                                    <br>
                                    <!-- Nav pills -->
                                    <div class="col-centered">
                                        <ul class="nav nav-pills" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="pill" href="#login">Masuk</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="pill" href="#register">Daftar</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div id="login" class="tab-pane active"><br>
                                            <form class="forms-sample" action="./login.php" method="post">
                                                <div class="form-group">
                                                    <label class="label">Email</label>
                                                    <div class="input-group">
                                                        <input type="email" name="email" class="form-control" placeholder="Username" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="mdi mdi-check-circle-outline"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label">Password</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password"class="form-control" placeholder="*********" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="mdi mdi-check-circle-outline"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input type="submit" name="login" class="btn btn-primary submit-btn btn-block" value="Masuk">
                                                        </div>
                                                    </div>    
                                                </div>
                                                <div class="form-group d-flex justify-content-between">
                                                    <div class="form-check form-check-flat mt-0">
                                                        <!-- <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" checked> Biarkan
                                                            tetap masuk
                                                        </label> -->
                                                    </div>
                                                    <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="register" class="tab-pane"><br>
                                            <form class="forms-sample" action="./login.php" method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label class="label">Nama Lengkap</label>
                                                    <div class="input-group">
                                                        <input type="text" name="namaLengkap" class="form-control" placeholder="Nama Lengkap" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="mdi mdi-check-circle-outline"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label">Email</label>
                                                    <div class="input-group">
                                                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="mdi mdi-check-circle-outline"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label">Tempat Lahir</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="tempatLahir" placeholder="Tempat lahir" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="mdi mdi-check-circle-outline"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label">Tanggal Lahir</label>
                                                    <div class="input-group">
                                                        <input type="date" name="tanggalLahir" class="form-control" placeholder="Tanggal Lahir" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="mdi mdi-check-circle-outline"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12">Jenis - Kelamin</label>
                                                    <div class="col-sm-6">
                                                        <div class="form-radio">
                                                        <label class="form-check-label">
                                                            <input type="radio" name="gender" class="form-check-input" id="membershipRadios1" value="Laki-laki" required> Laki-laki
                                                        </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-radio">
                                                        <label class="form-check-label">
                                                            <input type="radio" name="gender" class="form-check-input"  id="membershipRadios2" value="Perempuan" required> Perempuan
                                                        </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label">Pendidikan Terakhir Kali</label>
                                                    <div class="input-group">
                                                        <select class="form-control" name="idgolongan" required>
                                                            '.$listGolongan.'
                                                        </select>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" name="sekolahUser" class="form-control" placeholder="Nama Sekolah" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label">Password</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password"class="form-control" placeholder="*********" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="mdi mdi-check-circle-outline"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label">Konfirmasi Password</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password2" class="form-control" placeholder="*********" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="mdi mdi-check-circle-outline"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" name="create_account" class="btn btn-primary col-md-12" value="Daftar">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <ul class="auth-footer">
                                        <p class="footer-text text-center">copyright © 2018 ARS. Infomatic Engineering UNILA .</p>
                                    </ul>
                                </div>
                            </div>
                            <!-- content-wrapper ends -->
                        </div>
                        <!-- page-body-wrapper ends -->
                    </div>
                    <!-- container-scroller -->
                </div>
                <!-- container-scroller -->

               '.Navigation::DefaultJavaScript().'
            </body>

            </html>
            ';
        }
    }
?>