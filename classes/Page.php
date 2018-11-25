<?php 
    class Page{
        public static function DefaultPage($title,$notif,$content){
            if($notif !=''){
                $n = '<div class="row"><span class="bg-info col-md-12 rounded  text-center text-bold text-light">
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
                            '.$n.'
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
        public static function LoginPage($title,$notif,$content){
            if($notif !=''){
                $n = '<div class="row"><span class="bg-danger col-md-12 rounded  text-center text-bold text-light">
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
                        <div class="content-wrapper d-flex  auth auth-bg-2 theme-one">
                        <div class="col-lg-5 col-sm-10 mx-auto">
                            <div class="auto-form-wrapper">
                                <div class="logo-login">
                                    <img src="./images/Logo.png" class="img-fluid">
                                </div>
                
                                '.$n.'
                                '.$content.'
                            </div>
                        </div>
                            <div class="col-lg-7 col-sm-10 mx-auto">
                                <div class="auto-form-wrapper">
                                <h4 class="col-sm-12">
                                Tentang Tarung Soal
                                </h4>              
                                <div class="col-sm-12">
                                    <p class="text-center">Pengembang</p>
                                </div>      
                                <div class="input-group col-sm-12">
                                    <img class="mb-3 mx-auto d-block " style="width:auto; height: 150px" src="'.Navigation::getSourceImageProfil(1).'" alt="Foto"/>
                                </div>                                
                                <div class="col-sm-12">
                                    <h4 class="text-center">Ardi Ragil Saputra</p>
                                </div>                               
                                
                                <div class="col-sm-12">
                                    <p class="text-center">Teknik Informatika 2016 <br> Universitas Lampung</p>
                                </div>                               

                                <div class="col-sm-12">
                                    <p>Tarung Soal adalah situs web yang digunakan untuk belajar mengerjakan soal
                                    dan situs untuk membuat soal anda sendiri dengan jumlah soal tak terbatas 
                                    dengan layanan yang gratis. situs ini ditunjukan untuk pendidik dan pelajar di seluruh indonesia
                                    yang tidak memiliki layanan seperti ujian yang basis online.
                                    </p>
                                    <p>
                                    Tarung Soal ini dibuat untuk melopori pembelajaran online dengan cara mengerjakan soal dengan
                                    dengan menggunakan teknologi informasi, terlebih lagi ketika anda ingin menguji kemampuan anak anda dengan soal buatan anda sendiri.
                                    </p>
                                    <p>
                                    Pengembang :
                                     " Untuk pemerataan pendidikan indonesia yang tidak memiliki situs ujian online dan ini gratis untuk semua".
                                    </p>
                                    <p>
                                        Untuk saat ini masih dalam pengembangan untuk aplikasi release dan penambahan fitur, terlebih lagi perbaikan ui yang user-friendly.
                                        Untuk membantu proyek ini dapat menghubungi 08877021819 (via WhatsApp).
                                    </p>
                                </div> 
                                
                                <p class="col-sm-12 text-center bg-light rounded">
                                - Berkolaborasi dengan Zakaa.id -
                                <br>
                                - Tugas Akhir Kuliah Pemrogramman Web -
                                <br>
                                Beta Versi 0.9
                                </p>
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
        public static function BlockContent($content1,$content2,$content3){
            return '
            <div class="row">
                <div class="col-md-12">
                    '.$content1.'
                </div>
                <br>
                <div class="col-md-12">
                    '.$content2.'
                </div>
                <br>
                <div class="col-md-12">
                    '.$content3.'
                </div>
            </div>
            ';
        }
        public static function List($nama,$content){
            return '
            <div class="table-responsive">
                <table class="table table-striped">
                <thead>
                    '.$nama.'
                </thead>
                <tbody>
                    '.$content.'
                </tbody>
                </table>
            </div>
            ';
        }
        public static function Title($title, $content){
            return '
            <div class="card">
                <div class="card-body">
                    <h4 class="Text-light alert alert-info p-3 text-center">'.$title.'</h4>
                    '.$content.'
                </div>
            </div>
            <br>
            ';
        }
        public static function Row($content){
            return '<div class="row">'.$content.'</div>';
         
        }
    }
?>