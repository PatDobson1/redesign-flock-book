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
                                    <inner>
                                        <h1>$site_data[site_name] flockbook</h1>
                                        <menu>
                                            <ul>
                                                <li><a href='$site_data[site_root]'>Dashboard</a></li>
                                                <li class='dropdown'><a>Menu 1</a>
                                                    <ul>
                                                        <li><a href='$site_data[site_root]/livestock'>Livestock</a></li>
                                                        <li><a href='#'>subMenu 2</a></li>
                                                        <li><a href='#'>subMenu even longer 3</a></li>
                                                        <li><a href='#'>subMenu 4</a></li>
                                                    </ul>
                                                </li>
                                                <li class='dropdown'><a href='#'>Menu 2</a>
                                                    <ul>
                                                        <li><a href='#'>subMenu 1</a></li>
                                                        <li><a href='#'>subMenu 2</a></li>
                                                        <li><a href='#'>subMenu 3</a></li>
                                                        <li><a href='#'>subMenu 4</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href='#'>Menu 3</a></li>
                                                <li><a href='#'>Menu 4</a></li>
                                                <li><a href='#'>Menu 5</a></li>
                                                <li class='dropdown'><a href='#'>Menu 6</a>
                                                    <ul>
                                                        <li><a href='#'>subMenu 1</a></li>
                                                        <li><a href='#'>subMenu 2</a></li>
                                                        <li><a href='#'>subMenu 3</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </menu>
                                        <rightMenu>
                                            <ul>
                                                <li class='dropdown'><a href='#'>Menu 1</a>
                                                    <ul>
                                                        <li><a href='#'>subMenu 1</a></li>
                                                        <li><a href='#'>subMenu a bit long 2</a></li>
                                                        <li><a href='#'>subMenu 3</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href='#'>Menu 2</a></li>
                                                <li class='dropdown'><a href='#'>Menu 3</a>
                                                    <ul>
                                                        <li><a href='#'>subMenu 1</a></li>
                                                        <li><a href='#'>subMenu 2</a></li>
                                                        <li><a href='#'>subMenu 3</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </rightMenu>
                                    </inner>
                                </header>
                                <content>";

            }
        // -----------------------------------------------------

        // -- Footer -------------------------------------------
            public function footer(){

                echo "
                        </content>
                        <footer>
                            <div class='col_2'>
                                <div>left</div>
                                <div>right</div>
                            </div>
                        </footer>
                    </div>
                </body>
            </html>";

            }
        // -----------------------------------------------------

    }

?>
