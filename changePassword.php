<?php
/*
* this page allows volunteers to change their password
*/
session_start();
session_cache_expire(30);
?>
<html>
    <head>
        <title>
            Change password
        </title>
        <link rel="stylesheet" href="styles.css" type="text/css" />
        <style>
        	#appLink:visited {
        		color: gray; 
        	}
        </style> 
    </head>
    <body>
        <div id="container">
            <?PHP include('header.php'); ?>
            <div id="content">
                <?PHP
                include_once('database/dbPersons.php');
                include_once('domain/Person.php');
                include_once('database/dbLog.php');
                include_once('domain/Shift.php');
                include_once('database/dbShifts.php');
                date_default_timezone_set('America/New_York');
            //    fix_all_birthdays();
                if ($_SESSION['_id'] != "guest") {
                    $person = retrieve_person($_SESSION['_id']);
                    //echo "<p>Welcome, " . $person->get_first_name() . ", to Homebase!";
                }
                else 
                    //echo "<p>Welcome!";
                //echo "   Today is " . date('l F j, Y') . ".<p>";
                ?>

                <!-- your main page data goes here. This is the place to enter content -->
                <p>
                    <?PHP
                    if ($_SESSION['access_level'] == 0)
                        echo('<p>');
                    if ($person) {


                        //APPLICANT CHECK
                        if ($person->get_first_name() != 'guest' && $person->get_status() == 'applicant') {
                            echo('You do not have permission to view this page');
                        }

                        //VOLUNTEER CHECK
                        if ($_SESSION['access_level'] == 1) {
                        	

                               if (md5($person->get_id()) == $person->get_password() || ['access_level'] > 0) {
                                if (!isset($_POST['_rp_submitted']))
                                    echo('<p><div><form method="post"><p><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="right" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></td></tr></table></p></form></div>');
                                else {
                                    //they've submitted
                                    if (($_POST['_rp_newa'] != $_POST['_rp_newb']) || (!$_POST['_rp_newa']))
                                        echo('<div><form method="post"><p>Error with new password. Ensure passwords match.</p><br /><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form></td></tr></table></div>');
                                    else if (md5($_POST['_rp_old']) != $person->get_password())
                                        echo('<div><form method="post"><p>Error with old password.</p><br /><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form></td></tr></table></div>');
                                    else if ((md5($_POST['_rp_old']) == $person->get_password()) && ($_POST['_rp_newa'] == $_POST['_rp_newb'])) {
                                        $newPass = md5($_POST['_rp_newa']);
                                        change_password($person->get_id(), $newPass);
                                        echo('Password has been updated');
                                    }
                                }
                                
                                echo('<br clear="all">');
                            }
                            




                            
                            // link to personal profile for editing
                            /*echo('<br><div class="scheduleBox"><p><strong>Your Personal Profile:</strong><br /></p><ul>');  
                                echo('</ul><p>Go <strong><a href="personEdit.php?id='.$person->get_id()
                        	   .'">here</a></strong> to view or update your contact information.</p></div>');*/
                            // link to personal log sheet
                            /*echo('<br><div class="scheduleBox"><p><strong>Your Log Sheet:</strong><br /></p><ul>');
                                echo('</ul><p>Go <strong><a href="volunteerLog.php?id='.$person->get_id()
                        	   .'">here</a></strong> to view or enter your recent volunteering hours.</p></div>');*/
              
                        }
                        
                        if ($_SESSION['access_level'] == 2) {
                            //We have a manager authenticated
                            
                            if (md5($person->get_id()) == $person->get_password() || ['access_level'] > 0) {
                                if (!isset($_POST['_rp_submitted']))
                                    echo('<p><div><form method="post"><p><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="right" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></td></tr></table></p></form></div>');
                                else {
                                    //they've submitted
                                    if (($_POST['_rp_newa'] != $_POST['_rp_newb']) || (!$_POST['_rp_newa']))
                                        echo('<div><form method="post"><p>Error with new password. Ensure passwords match.</p><br /><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form></td></tr></table></div>');
                                    else if (md5($_POST['_rp_old']) != $person->get_password())
                                        echo('<div><form method="post"><p>Error with old password.</p><br /><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form></td></tr></table></div>');
                                    else if ((md5($_POST['_rp_old']) == $person->get_password()) && ($_POST['_rp_newa'] == $_POST['_rp_newb'])) {
                                        $newPass = md5($_POST['_rp_newa']);
                                        change_password($person->get_id(), $newPass);
                                        echo('Password has been updated');
                                    }
                                }
                                
                                echo('<br clear="all">');
                            }


                
                        	
  
                        }
    

                    }
                    ?>
                    </div>
                    <?PHP include('footer.inc'); ?>
        </div>
    </body>
</html>