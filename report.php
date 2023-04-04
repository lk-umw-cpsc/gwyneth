<?php 
  session_cache_expire(30);
  session_start();
  ini_set("display_errors",1);
  error_reporting(E_ALL);
  $loggedIn = false;
  $accessLevel = 0;
  $userID = null;
  if (isset($_SESSION['_id'])) {
      $loggedIn = true;
      // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
      $accessLevel = $_SESSION['access_level'];
      $userID = $_SESSION['_id'];
  }
  require_once('include/input-validation.php');
  if ($accessLevel < 2) {
    header('Location: index.php');
    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | Reports Page</title>
        <style>
            main.rep {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
            }
        </style>
    </head>
    <body>
        <?php require_once('header.php');
	    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_click"]) && isset($_POST["report_type"]) || isset($_POST["date_from"])) {
		    $type = $_POST['report_type'];
		    header("Location: /gwyneth/reportsPage.php?report_type=$type");
	    } 
	    ?>
        <h1>Reports</h1>
    <main class="rep">
        <h2>Generate Report</h2>
        <form class="genRep" method="post">
            <label for="report_type">Select Report Type</label>
            <select name="report_type" id="report_type">
                <option value = "general_volunteer_report">General Volunteer Report</option>
                <option value = "top_perform">Top Performers</option>
                <option value = "total_hours">Total Hours</option>
            </select>
            <label for="date_from">Date Range Start</label>
            <input name = "date_from" type="date" id="date_from" placeholder="yyyy-mm-dd">
            <label for="date_to">Date Range End</label>
            <input name = "date_to" type="date" id="date_to" placeholder="yyyy-mm-dd">
            <label for="lname_start">Last Name Range Start</label>
            <input name = "lname_start" type="text" id="lname_start" placeholder="a-z">
            <label for="lname_end">Last Name Range End</label>
            <input name = "lname_end" type="text" id="lname_end" placeholder="a-z">
            <input type="submit" name="submit_click">

        </form>

    </main>

    </body>

</html>