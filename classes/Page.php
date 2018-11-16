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
    }
?>