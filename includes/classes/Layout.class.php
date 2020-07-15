<?php

    class Layout extends Db{
        
        // -- Header -------------------------------------------
            public function header(){

                echo "
                        <html>
                            <head>
                                <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Raleway:wght@300;600&display=swap' rel='stylesheet'>
                                <link rel='stylesheet' href='includes/style/reset.css' />
                                <link rel='stylesheet' href='includes/style/style.css' />
                            </head>
                            <body>
                            <div class='overall'>
                                <header>
                                    <h1>H E A D E R</h1>
                                </header>
                                <content>";

            }
        // -----------------------------------------------------
        
        // -- Footer -------------------------------------------
            public function footer(){
             
                echo "
                        </content>
                        <footer>
                            <p>F O O T E R</p>
                        </footer>
                    </div>
                </body>
            </html>";
                
            }
        // -----------------------------------------------------
        
    }

?>