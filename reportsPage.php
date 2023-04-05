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

  $get = sanitize($_GET);
  $type = $get['report_type'];
  $dateFrom = $_GET['date_from'];
  $dateTo = $_GET['date_to'];
  $lastFrom = $_GET['lname_start'];
  $lastTo = $_GET['lname_end'];
  // Is user authorized to view this page?
  if ($accessLevel < 2) {
      header('Location: index.php');
      die();
  }
  function getBetweenDates($startDate, $endDate){
      $rangArray = [];
          
      $startDate = strtotime($startDate);
      $endDate = strtotime($endDate);
           
      for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
      }

      return $rangArray;
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | Reports Page</title>
        <style>
            table {
                margin-top: 1rem;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #333333;
                text-align: left;
                padding: 8px;
            }
          
            tr:nth-child(even) {
                background-color: #2f4159;
                color: white;
            }
            .lastNameDiv{
                margin-bottom: 3rem;

            }
            .theB{
                width: auto;
                font-size: 15px;
            }
            .center_b{
                margin-top: 3rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }
    </style>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>Reports Page</h1>
        <main class="rep">
        <div>
            <label>Reports Type:</label>
            <span>
                <?php 
                if($type == "top_performers"){
                    echo "Top Performers"; 
                }elseif($type == "general_volunteer_report"){
                    echo "General Volunteer Report";
                }
                ?> 
            </span>
        </div>
        <div>
            <label>Date Range:</label>
            <span>
                <?php
                // if date from is provided but not date to, assume admin wants all dates from given date to current
                    if(isset($dateFrom) && !isset($dateTo)){
                        echo $dateFrom, " to Current";
                // if date from is not provided but date to is, assume admin wants all dates prior to the date given
                    }elseif(!isset($dateFrom) && isset($dateTo)){
                        echo "Every date till ", $dateTo;
                // if date from and date to is not provided assume admin wants all dates
                    }elseif($dateFrom == NULL && $dateTo ==NULL){
                        echo "All date";
                    }else{
                        echo $dateFrom ," to ", $dateTo;
                        getBetweenDates($dateFrom,$dateTo);
                    } 
                ?> 
            </span>
        </div>
        <div class= "lastNameDiv">
            <label>Last Name Range:</label>
            <span>
                <?php 
                    if($lastFrom == NULL && $lastTo == NULL){
                        echo "All Last Name";
                    }else{
                        echo $lastFrom, " to " , $lastTo;
                    }
                 //SELECT * FROM department WHERE NAME LIKE 'H%';
                 ?> 
            </span>
        </div>
        <h3 style="font-weight: bold">Result: <h3>
        <table>
        <tr>
            <th>Firs Name</th>
            <th>Last Name</th>
            <th>Phone Number</th>
            <th>Email Address</th>
            <th>Hours Volunteered</th>
        </tr>
        <tbody>
        <?php 
    
        if($type == "general_volunteer_report"){
            require_once('database/dbPersons.php');
            require_once('database/dbEvents.php');
            $con=connect();
            $type1 = "volunteer";
            $query = "SELECT * FROM dbPersons WHERE type LIKE '%" . $type1 . "%' ";
            $result = mysqli_query($con,$query);
            while($row = mysqli_fetch_assoc($result)){
                echo"<tr>
                <td>" . $row['first_name'] . "</td>
                <td>" . $row['last_name'] . "</td>
                <td>" . $row['phone1'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . get_hours_volunteered_by($row['id']) . "</td>
                </tr>";
            }
        }elseif($type == "top_performers"){
            require_once('database/dbPersons.php');
            $con=connect();
            $type1 = "volunteer";
            $query = "SELECT * FROM dbPersons WHERE type LIKE '%" . $type1 . "%' ORDER BY hours DESC";
            $result = mysqli_query($con,$query);
            while($row = mysqli_fetch_assoc($result)){
                echo"<tr>
                <td>" . $row['first_name'] . "</td>
                <td>" . $row['last_name'] . "</td>
                <td>" . get_hours_volunteered_by($row['id']) . "</td>
                </tr>";
            }
        }
    
        ?>
        </tbody>
        </table>
        <div class="center_b"><a href="http://localhost/gwyneth/report.php">
            <button class = "theB">New Report</button>
        </a></div>
        </main>
    </body>
</html>