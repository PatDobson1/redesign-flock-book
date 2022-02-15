<?php

    class Mail extends Db{

        // -- Gather reminder emails -------------------------------------------
            public function getReminders($site_data){

                // -- Due today ------------------------------------------------
                    $this -> connect();
                        $query = "SELECT *
                                  FROM reminders
                                  WHERE reminder_date IS NOT null
                                  AND reminder_date = CURRENT_DATE()
                                  AND completed != 1";
                        $sql = self::$conn -> prepare($query);
                        $sql -> execute();
                    $this -> disconnect();

                    $dueToday = [];
                    while( $row = $sql -> fetch() ){
                        array_push( $dueToday, $row['id'] );
                    }
                // -------------------------------------------------------------

                // -- Due in 1 month -------------------------------------------
                    $this -> connect();
                        $query = "SELECT *
                                  FROM reminders
                                  WHERE reminder_date IS NOT null
                                  AND reminder_date = (CURRENT_DATE + INTERVAL 1 MONTH)
                                  AND completed != 1";
                        $sql = self::$conn -> prepare($query);
                        $sql -> execute();
                    $this -> disconnect();

                    $dueIn1Month = [];
                    while( $row = $sql -> fetch() ){
                        $beforeArray = explode(',',$row['remindMe_before']);
                        if( in_array('1 Month', $beforeArray) ){
                            array_push($dueIn1Month, $row['id']);
                        }
                    }
                // -------------------------------------------------------------

                // -- Due in 1 week --------------------------------------------
                    $this -> connect();
                        $query = "SELECT *
                                  FROM reminders
                                  WHERE reminder_date IS NOT null
                                  AND reminder_date = (CURRENT_DATE + INTERVAL 1 WEEK)
                                  AND completed != 1";
                        $sql = self::$conn -> prepare($query);
                        $sql -> execute();
                    $this -> disconnect();

                    $dueIn1Week = [];
                    while( $row = $sql -> fetch() ){
                        $beforeArray = explode(',',$row['remindMe_before']);
                        if( in_array('1 Week', $beforeArray) ){
                            array_push($dueIn1Week, $row['id']);
                        }
                    }
                // -------------------------------------------------------------

                // -- Due in 1 day ---------------------------------------------
                    $this -> connect();
                        $query = "SELECT *
                                  FROM reminders
                                  WHERE reminder_date IS NOT null
                                  AND reminder_date = (CURRENT_DATE + INTERVAL 1 DAY)
                                  AND completed != 1";
                        $sql = self::$conn -> prepare($query);
                        $sql -> execute();
                    $this -> disconnect();

                    $dueIn1Day = [];
                    while( $row = $sql -> fetch() ){
                        $beforeArray = explode(',',$row['remindMe_before']);
                        if( in_array('1 Day', $beforeArray) ){
                            array_push($dueIn1Day, $row['id']);
                        }
                    }
                // -------------------------------------------------------------

                // -- Overdue - daily ------------------------------------------
                    $this -> connect();
                        $query = "SELECT *
                                  FROM reminders
                                  WHERE reminder_date IS NOT null
                                  AND reminder_date < CURRENT_DATE()
                                  AND completed != 1";
                        $sql = self::$conn -> prepare($query);
                        $sql -> execute();
                    $this -> disconnect();

                    $overdueDaily = [];
                    while( $row = $sql -> fetch() ){
                        $afterArray = explode(',',$row['remindMe_after']);
                        if( in_array('Daily', $afterArray) ){
                            array_push($overdueDaily, $row['id']);
                        }
                    }
                // -------------------------------------------------------------

                // -- Overdue - weekly -----------------------------------------
                    $this -> connect();
                        $query = "SELECT *
                                  FROM reminders
                                  WHERE reminder_date IS NOT null
                                  AND reminder_date < CURRENT_DATE()
                                  AND reminder_date = (CURRENT_DATE - INTERVAL 1 WEEK)
                                  AND completed != 1";
                        $sql = self::$conn -> prepare($query);
                        $sql -> execute();
                    $this -> disconnect();

                    $overdueWeekly = [];
                    while( $row = $sql -> fetch() ){
                        $afterArray = explode(',',$row['remindMe_after']);
                        if( in_array('Weekly', $afterArray) ){
                            array_push($overdueWeekly, $row['id']);
                        }
                    }
                // -------------------------------------------------------------

                // -- Overdue - Monthly ----------------------------------------
                    $this -> connect();
                        $query = "SELECT *
                                  FROM reminders
                                  WHERE reminder_date IS NOT null
                                  AND reminder_date < CURRENT_DATE()
                                  AND reminder_date = (CURRENT_DATE - INTERVAL 1 MONTH)
                                  AND completed != 1";
                        $sql = self::$conn -> prepare($query);
                        $sql -> execute();
                    $this -> disconnect();

                    $overdueMonthly = [];
                    while( $row = $sql -> fetch() ){
                        $afterArray = explode(',',$row['remindMe_after']);
                        if( in_array('Monthly', $afterArray) ){
                            array_push($overdueMonthly, $row['id']);
                        }
                    }
                // -------------------------------------------------------------

                // -- Overdue --------------------------------------------------
                    $overdueArray = array_unique(array_merge($overdueDaily, $overdueWeekly, $overdueMonthly));
                // -------------------------------------------------------------

                $this -> processEmails($dueToday, $site_data);
                $this -> processEmails($dueIn1Month, $site_data);
                $this -> processEmails($dueIn1Week, $site_data);
                $this -> processEmails($dueIn1Day, $site_data);
                $this -> processEmails($overdueArray, $site_data);

                echo "<p>Emails sent</p>";

            }
        // ---------------------------------------------------------------------

        // -- Process reminder email(s) ----------------------------------------
            private function processEmails($ids, $site_data){

                if(count($ids)){
                    $this -> connect();
                        $query = "SELECT * FROM reminders where id IN (" . implode(',', $ids) . ")";
                        $sql = self::$conn -> prepare($query);
                        $sql -> execute();
                        $count = $sql -> rowCount();
                    $this -> disconnect();

                    while( $row = $sql -> fetch() ){
                        $data = new stdClass();
                        $data -> reminder_date = $row['reminder_date'];
                        $data -> description = $row['description'];
                        $data -> priority = $row['priority'];
                        $data -> emails = $row['emails'];
                        $data -> siteUrl = "https://" . $site_data['site_subDomain'] . ".farmstockbook.co.uk";
                        $this -> reminderEmail($data, $site_data);
                    }
                }

            }
        // ---------------------------------------------------------------------

        // -- Send single reminder email ---------------------------------------
            private function reminderEmail($data, $site_data){
                
                require 'includes/class.phpmailer.php';
                $emailAddresses = [];
                if( $data -> emails != '' ){
                    $emailAddresses = explode(",",$data -> emails);
                }else{
                    array_push($emailAddresses, $site_data['base_email']);
                }

                var_dump($emailAddresses);

                foreach($emailAddresses as $address){
                    $to = $address;
                    $subject = "FarmStockBook - reminder";
                    $txt = $this -> emailHeader();
                    $txt .= $this -> emailBody($data);
                    $txt .= $this -> emailFooter();
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: <admin@farmstockbook.co.uk>' . "\r\n";
                    mail($to,$subject,$txt,$headers);
                }

            }
        // ---------------------------------------------------------------------

        // -- Email header -----------------------------------------------------
            private function emailHeader(){

                return    '<!DOCTYPE html>
                        <html lang="en">
                          <head>
                            <title>FarmStockBook - Reminder</title>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                            <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Open+Sans:wght@300;600&display=swap" rel="stylesheet">
                            <style type="text/css">
                                /* CLIENT-SPECIFIC STYLES */
                                body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: "Open Sans", sans-serif; }
                                table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
                                img { -ms-interpolation-mode: bicubic; }
                                /* RESET STYLES */
                                img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
                                table { border-collapse: collapse !important; }
                                body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
                                /* iOS BLUE LINKS */
                                a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important; line-height: inherit !important; }
                                /* GMAIL BLUE LINKS */
                                u + #body a { color: inherit; text-decoration: none; font-size: inherit; font-family: inherit; font-weight: inherit; line-height: inherit; }
                                /* SAMSUNG MAIL BLUE LINKS */
                                #MessageViewBody a { color: inherit; text-decoration: none; font-size: inherit; font-family: inherit; font-weight: inherit; line-height: inherit;}
                                /* These rules set the link and hover states, making it clear that links are, in fact, links. */
                                /* Embrace established conventions like underlines on links to keep emails accessible. */
                                a { color: #B200FD; font-weight: 600; text-decoration: underline; }
                                a:hover { color: #000000 !important; text-decoration: none !important; }
                                /* These rules adjust styles for desktop devices, keeping the email responsive for users. */
                                /* Some email clients don`t properly apply media query-based styles, which is why we go mobile-first. */
                                @media screen and (min-width:600px) {
                                    h1 { font-size: 48px !important; line-height: 48px !important; }
                                    .intro { font-size: 24px !important; line-height: 36px !important; }
                                }
                            </style>                         
                        </head>
                        <body style="margin: 0 !important; padding: 0 !important; background-color: #c4dcc4;">
                        <!--[if (gte mso 9)|(IE)]>
                        <table cellspacing="0" cellpadding="0" border="0" width="600" align="center" role="presentation"><tr><td>
                        <![endif]-->
                        <!-- The role and aria-label attributes are added to wrap the email content as an article for screen readers. Some of them will read out the aria-label as the title of the document, so use something like "An email from Your Brand Name" to make it recognizable. -->
                        <div role="article" aria-label="FarmStockBook - Reminder" lang="en" style="background-color: white; color: #2b2b2b; font-size: 18px; font-weight: 400; line-height: 28px; margin: 0 auto; max-width: 600px; padding: 20px; background-color: #ffffff;">';
            }
        // ---------------------------------------------------------------------

        // -- Email body -------------------------------------------------------
            private function emailBody($data){
                $functions = new Functions();
                $description = nl2br($data->description);
                $date = $functions -> fullDateFormat($data->reminder_date);
                return "<header>
                            <h1 style='color: #000000; font-size: 24px!important; font-weight: 600; line-height: 20px; '>
                                FarmStockBook - Reminder
                            </h1>
                        </header>

                        <main>
                            <p class='intro' style='color: #000000; font-size: 14px!important; font-weight: 300; line-height: 12px; margin: 0!important;'>Due date : $date</p>
                            <p style='background-color: #e6e6e6; display: block; height: 1px;'>&nbsp;</p>
                            <p>$description</p>
                            <p style='background-color: #e6e6e6; display: block; height: 1px;'>&nbsp;</p>
                        </main>

                        <footer>
                            <p style='font-size: 12px; font-weight: 400; line-height: 24px; margin-top: 48px;'>You received this email because you set a reminder at FarmStockBook. It can be viewed and edited <a href='$data->siteUrl' style='color: #a2a2f7; text-decoration: underline;'>here</a></p>
                        </footer>";
            }
        // ---------------------------------------------------------------------

        // -- Email footer -----------------------------------------------------
            private function emailFooter(){
                return '
                            </div>
                            <!--[if (gte mso 9)|(IE)]>
                            </td></tr></table>
                            <![endif]-->
                            </body>
                            </html>';
            }
        // ---------------------------------------------------------------------
    }

?>
