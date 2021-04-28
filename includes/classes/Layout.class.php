<?php

    class Layout extends Db{

        // -- Header -------------------------------------------
            public function header($site_data){
                $menu = new Menu();
                echo "
                        <html>
                            <head>
                                <meta charset='utf-8'>
                                <meta content='width=device-width, initial-scale=1.0' name='viewport'>
                                <link rel='icon' href='$site_data[site_root]/favicon.ico'>
                                <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Open+Sans:wght@300;600&display=swap' rel='stylesheet'>
                                <link rel='stylesheet' href='includes/style/style.css' />
                            </head>
                            <body data-root='$site_data[site_root]'>
                            <div class='overall'>
                                <header>
                                    <inner>
                                        <h1>$site_data[site_name] StockBook</h1>";
                                        $menu -> mainMenu($site_data);
                                        $menu -> rightMenu($site_data);
                                        $menu -> mobileMenu($site_data);
                echo "              </inner>
                                </header>
                                <content>";

            }
        // -----------------------------------------------------

        // -- Footer -------------------------------------------
            public function footer(){
                $date = date('Y');
                echo "
                        <p class='js-top'><button></button></p>
                        </content>
                        <footer>
                            <div class='col_3'>
                                <div>
                                    <p>All content &copy;$date Stock-Book</p>
                                </div>
                                <div>
                                    <p><a href='/terms'>Terms and conditions</a></p>
                                </div>
                                <div>Support contact <a href='mailto:admin@farmstockbook.co.uk'>admin@farmstockbook.co.uk</a></div>
                            </div>
                        </footer>
                    </div>
                    <div class='modalFade'><div class='modal'></div></div>
                </body>
                <script src='includes/js/libs/jquery.3.5.1.js'></script>
                <script src='includes/js/functions.js'></script>
            </html>";

            }
        // -----------------------------------------------------

    }

?>
