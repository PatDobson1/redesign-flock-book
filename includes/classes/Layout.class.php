<?php

    class Layout extends Db{
        
        // -- Header -------------------------------------------
            public function header(){

                echo "
                        <html>
                            <head>
                                <link rel='stylesheet' href='includes/style/style.css' />
                            </head>
                            <body>
                            <div class='overall'>
                                <div class='header'>
                                    <h1>H E A D E R</h1>
                                </div>
                                <hr/ >
                                <div class='content'>";

            }
        // -----------------------------------------------------
        
        // -- Footer -------------------------------------------
            public function footer(){
             
                echo "
                        </div>
                        <hr />
                        <div class='footer'>
                            <p>F O O T E R</p>
                        </div>
                    </div>
                </body>
            </html>";
                
            }
        // -----------------------------------------------------
        
    }

?>