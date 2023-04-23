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
  require_once('database/dbPersons.php');

  if ($accessLevel < 2) {
    header('Location: index.php');
    die();
  }

?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | Reports</title>
        <style>
            .report_select{
                display: flex;
                flex-direction: column;
                gap: .5rem;
                padding: 0 0 4rem 0;
            }
            @media only screen and (min-width: 1024px) {
                .report_select {
                    /* width: 40%; */
                    width: 35rem;
            }
            main.report {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
	    .column {
		padding: 0 4rem 0 0;
		width: 50%;
	    }
	    .row{
          	display: flex;
            }
	    }
	    .hide {
  		display: none;
	    }

	    .myDIV:hover + .hide {
		display: block;
  		color: red;
	    }
        </style>
    </head>
    <body>
        <?php require_once('header.php');?>
	<h1>Business and Operational Reports</h1>

    <main class="report">
	<?php
	    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_click"]) 
        && isset($_POST["report_type"]) && isset($_POST["date_from"]) && 
        isset($_POST["date_to"]) && isset($_POST['lname_start']) && isset($_POST['lname_end']) 
        && isset($_POST['name']) && isset($_POST['statusFilter'])) {
		$args = sanitize($_POST);
		$report = $args['report_type'];
		$name = $args['name'];
		
		$dFrom = $_POST['date_from'];
        	$dTo = $_POST['date_to'];
		if ($dTo > $dFrom) {
		    echo "<b>Please enter a date after the Date Range Start.</b><br>";	
		}
        	$lastFrom = $_POST['lname_start'];
        	$lastTo = $_POST['lname_end'];
		if (strcmp(strtoupper($lastTo),strtoupper($lastFrom)) > 0) {
		    echo "<b>Please enter a letter after the Last Name Range Start.</b><br>";
		}

        	$status = $_POST['statusFilter'];

		if ($report=="indiv_vol_hours" && $name == NULL) {
			echo "<b>Please enter a volunteer's first and/or last name.</b><br>";
		}
	    	elseif ($report=="indiv_vol_hours" && $name != NULL) {
			echo "<h3>Search Results</h3>";
			$persons = find_user_names($name);
                        require_once('include/output.php');
                        if (count($persons) > 0) {
                            echo '
                            <div class="table-wrapper">
                                <table class="general">
                                    <thead>
                                        <tr>
                                            <th>First</th>
                                            <th>Last</th>
					    <th>Email</th>
					    <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="standout">';
                            foreach ($persons as $person) {
                                echo '
                                     <tr>
                                         <td>' . $person->get_first_name() . '</td>
                                         <td>' . $person->get_last_name() . '</td>
 					 <td><a href="mailto:' . $person->get_id() . '">' . $person->get_id() . '</a></td>
				     <td><a href="reportsPage.php?report_type='. $report .'&date_from='. $dFrom .'&date_to='. $dTo .'&lname_start='. $lastFrom .'&lname_end='. $lastTo .'&name='. $name .'&indivID='. $person->get_id().' &role='. $person->get_type()[0] .' &status= '.$person->get_status().' ">Run Report</a></td>
				     </tr>';
                            }
                            echo '
                                    </tbody>
                                </table>
                            </div>';
                        } else {
                            echo '<div class="error-toast">Your search returned no results.</div>';
                        }
               }
	    	else {
			// header("Location: /gwyneth/reportsPage.php?report_type=$report&date_from=$dFrom&date_to=$dTo&lname_start=$lastFrom&lname_end=$lastTo&name=$name&statusFilter=$status");
                // NOT IDEAL. Can be broken by browsers with JS disabled.
                echo "<script>window.location.href = 'reportsPage.php?report_type=$report&date_from=$dFrom&date_to=$dTo&lname_start=$lastFrom&lname_end=$lastTo&name=$name&statusFilter=$status';</script>";
	    	}
	    } 
            // $alphabet = range('a', 'z');
            // foreach ($alphabet as $letter) {
            //     echo $letter . " ";
            // }
	    ?>
        
	<h2>Generate Report</h2>
	<br>

        <form class="report_select" method="post">
	<div>

            <label for="report_type">Select Report Type</label>
            <select name="report_type" id="report_type">
                <option value = "general_volunteer_report">General Volunteer Report</option>
                <option value = "total_vol_hours">Total Volunteer Hours</option>
                <option value = "indiv_vol_hours">Individual Volunteer Hours</option>
                <option value = "top_perform">Top Performers</option>
            </select>
	</div>
	<br>
	<div>
	 <label>Status </label>
	<?php
            // Set filter on status of volunteers to return in the report result
	    echo '&nbsp&nbsp&nbsp&nbsp&nbsp';
            echo '<input type="radio" name="statusFilter" id = "allStatus" value="All" checked>&nbspAll&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
            echo '<input type="radio" name="statusFilter" id = "isActive" value="Active" >&nbspActive&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
            echo '<input type="radio" name="statusFilter" id = "isInactive" value="Inactive">&nbspInactive&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
	?>
	</div>
	<br>
	<div class="row">
	<div class="column">
	    <label for="date_from">Date Range Start</label>
            <input name = "date_from" type="date" id="date_from" placeholder="yyyy-mm-dd">
        </div>
	<div class="column">
	    <label for="date_to">Date Range End</label>
            <input name = "date_to" type="date" id="date_to" placeholder="yyyy-mm-dd">
        </div>
	</div>
	<br>
	<div class="row">
	<div class="column">
	    <label for="lname_start">Last Name Range Start</label>
            <input name = "lname_start" type="text" id="lname_start" placeholder="A-Z">
        </div>
	<div class="column">
	    <label for="lname_end">Last Name Range End</label>
            <input name = "lname_end" type="text" id="lname_end" placeholder="A-Z">
	</div>
	</div>
	<div>
	    <label for="name">Name</label> <span><i><font size="3">*Individual Hours Report Only</font></i></span>
            <input type="text" id="name" name="name" value="" placeholder="Enter a volunteer's first and/or last name">
	</div>

            <input type="submit" name="submit_click">
	
        </form>

    </main>

    </body>

</html>
