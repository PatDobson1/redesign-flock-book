<?php

    class Menu{

        public function mainMenu($site_data){
            echo "<menu>
                <ul>
                    <li><a href='$site_data[site_root]/'>Dashboard</a></li>
                    <li class='dropdown'><a>Livestock</a>
                        <ul>
                            <li><a href='$site_data[site_root]/livestock'>Livestock</a></li>
                            <li><a href='$site_data[site_root]/species'>Species</a></li>
                            <li><a href='$site_data[site_root]/breeds'>Breeds</a></li>
                            <li><a href='$site_data[site_root]/diary'>Diary</a></li>
                            <li><a href='$site_data[site_root]/archive'>Archive</a></li>
                        </ul>
                    </li>
                    <li class='dropdown'><a href='#'>Data</a>
                        <ul>
                            <li><a href='$site_data[site_root]/suppliers'>Suppliers</a></li>
                            <li><a href='$site_data[site_root]/feed'>Feed</a></li>
                            <li><a href='$site_data[site_root]/medicine'>Medicine</a></li>
                            <li><a href='$site_data[site_root]/manualTreatment'>Manual treatment</a></li>
                        </ul>
                    </li>
                </ul>
            </menu>";
        }

        public function rightMenu($site_data){
            echo "<rightMenu>
                <ul>
                    <li><a href='#'>Menu 2</a></li>
                    <li class='dropdown'><a href='#'>Control</a>
                        <ul>
                            <li><a class='icon_settings' href='$site_data[site_root]/settings'>Settings</a></li>
                            <li><a class='icon_reminder' href='$site_data[site_root]/reminders'>Reminders</a></li>
                            <li><a class='icon_reminder' href='$site_data[site_root]/emailTest'>Email test</a></li>
                            <li><a class='js_print icon_print'>Print</a></li>
                            <li><a class='icon_logOut' href='$site_data[site_root]/?logout'>Log out</a></li>
                        </ul>
                    </li>
                </ul>
            </rightMenu>";
        }

        public function mobileMenu($site_data){
            echo "<div class='menuTrigger'><p></p><p></p><p></p></div>
                <div class='mobileMenu'>
                    <ul>
                        <li class='topLevel'><a href='$site_data[site_root]'>Dashboard</a></li>
                        <li class='title'>Livestock</li>
                        <li><a href='$site_data[site_root]/livestock'>View livestock</a></li>
                        <li><a href='$site_data[site_root]/species'>View species</a></li>
                        <li><a href='$site_data[site_root]/breeds'>View breeds</a></li>
                        <li><a href='$site_data[site_root]/archive'>Archive</a></li>
                        <li class='title'>Data</li>
                        <li><a href='$site_data[site_root]/suppliers'>Suppliers</a></li>
                        <li><a href='$site_data[site_root]/feed'>Feed</a></li>
                        <li><a href='$site_data[site_root]/medicine'>Medicine</a></li>
                        <li><a href='$site_data[site_root]/manualTreatment'>Manual treatment</a></li>
                        <li class='title'>Control</li>
                        <li><a class='icon_settings' href='$site_data[site_root]/settings'>Settings</a></li>
                        <li><a class='icon_reminder' href='$site_data[site_root]/reminders'>Reminders</a></li>
                        <li><a class='js_print icon_print'>Print</a></li>
                        <li><a class='icon_logOut' href='$site_data[site_root]/?logout'>Log out</a></li>
                    </ul>
                </div>";
        }

    }

?>
