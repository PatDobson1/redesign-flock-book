<?php

    class Layout extends Db{

        // -- Header -------------------------------------------
            public function header($site_data){
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
                                    <h1>$site_data[site_name] flockbook</h1>
                                    <menu>
                                        <ul>
                                            <li><a href='#'>Menu 1</a></li>
                                            <li><a href='#'>Menu 2</a></li>
                                            <li><a href='#'>Menu 3</a></li>
                                            <li><a href='#'>Menu 4</a></li>
                                            <li><a href='#'>Menu 5</a></li>
                                            <li><a href='#'>Menu 6</a></li>
                                        </ul>
                                    </menu>
                                    <rightMenu>
                                        <ul>
                                            <li><a href='#'>Menu 1</a></li>
                                            <li><a href='#'>Menu 2</a></li>
                                            <li><a href='#'>Menu 3</a></li>
                                        </ul>
                                    </rightMenu>
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
