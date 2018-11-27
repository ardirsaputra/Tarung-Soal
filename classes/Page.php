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
                                    '.$n.'    
                                <div class="logo-login">
                                    <img src="./images/Logo.png" class="img-fluid">
                                </div>
                
                                
                                '.$content.'
                                <br>
                                <p class="footer-text text-muted text-center">copyright © 2018 ARS. Infomatic Engineer <br>Universitas Lampung </p>
                            
                            </div>
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