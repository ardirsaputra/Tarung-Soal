<?php 
    class Page{
        public static function DefaultPage($title,$notif,$content){
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
                                    '.$content.'
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
        public static function Setting($content1,$content2,$content3){
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
        public static function Dashboard(){
            return '';
        }
    }
?>