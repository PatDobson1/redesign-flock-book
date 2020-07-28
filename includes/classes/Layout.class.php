<?php

    class Layout extends Db{

        // -- Header -------------------------------------------
            public function header($site_data){
                $menu = new Menu();
                echo "
                        <html>
                            <head>
                                <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Open+Sans:wght@300;600&display=swap' rel='stylesheet'>
                                <link rel='stylesheet' href='includes/style/reset.css' />
                                <link rel='stylesheet' href='includes/style/style.css' />
                            </head>
                            <body>
                            <div class='overall'>
                                <header>
                                    <inner>
                                        <h1>$site_data[site_name] flockbook</h1>";
                                        $menu -> mainMenu($site_data);
                                        $menu -> rightMenu($site_data);
                echo "              </inner>
                                </header>
                                <content>";

            }
        // -----------------------------------------------------

        // -- Footer -------------------------------------------
            public function footer(){
                $date = date('Y');
                echo "
                        </content>
                        <footer>
                            <div class='col_3'>
                                <div>
                                    <p>All content &copy;$date Flock-book</p>
                                </div>
                                <div>
                                    <p><a href='/terms'>Terms and conditions</a></p>
                                </div>
                                <div>For technical support contact <a href='mailto:admin@flock-book.uk'>admin@flock-book.uk</a></div>
                            </div>
                        </footer>
                    </div>
                </body>
                <script src='includes/js/libs/jquery.3.5.1.js'></script>
                <script src='includes/js/functions.js'></script>
            </html>";

            }
        // -----------------------------------------------------

    }

?>
