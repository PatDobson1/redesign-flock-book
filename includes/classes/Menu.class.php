<?php

    class Menu{

        public function mainMenu($site_data){
            echo "<menu>
                <ul>
                    <li><a href='$site_data[site_root]'>Dashboard</a></li>
                    <li class='dropdown'><a>Livestock</a>
                        <ul>
                            <li><a href='$site_data[site_root]/livestock'>View livestock</a></li>
                            <li><a href='$site_data[site_root]/species'>View species</a></li>
                            <li><a href='$site_data[site_root]/breeds'>View breeds</a></li>
                        </ul>
                    </li>
                    <li class='dropdown'><a href='#'>Data</a>
                        <ul>
                            <li><a href='$site_data[site_root]/suppliers'>Suppliers</a></li>
                            <li><a href='$site_data[site_root]/feed'>Feed</a></li>
                            <li><a href='$site_data[site_root]/medicine'>Medicine</a></li>
                        </ul>
                    </li>
                </ul>
            </menu>";
        }

        public function rightMenu($site_data){
            echo "<rightMenu>
                <ul>
                    <li class='dropdown'><a href='#'>Menu 1</a>
                        <ul>
                            <li><a href='#'>subMenu 1</a></li>
                            <li><a href='#'>subMenu a bit long 2</a></li>
                            <li><a href='#'>subMenu 3</a></li>
                        </ul>
                    </li>
                    <li><a href='#'>Menu 2</a></li>
                    <li class='dropdown'><a href='#'>Control</a>
                        <ul>
                            <li><a class='js_print icon_print'>Print</a></li>
                            <li><a class='icon_logOut'>Log out</a></li>
                        </ul>
                    </li>
                </ul>
            </rightMenu>";
        }

    }

?>
