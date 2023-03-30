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

  // $id = $get['id'];
  // Is user authorized to view this page?
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
                <?php echo "?"; ?> 
            </span>
        </div>
        <div class= "lastNameDiv">
            <label>Last Name Range:</label>
            <span>
                <?php echo "?"; ?> 
            </span>
        </div>
        <h3 style="font-weight: bold">Result: <h3>
        <table>
        <tr>
            <th>Firs Name</th>
            <th>Last Name</th>
            <th>Hours Volunteered</th>
            <th>Reg. Date</th>
        </tr>
        <tbody>
        <?php 
    if($type == "general_volunteer_report"){
        require_once('database/dbPersons.php');
        $con=connect();
        $type1 = "volunteer";
        $query = "SELECT first_name, last_name,id FROM dbPersons WHERE type LIKE '%" . $type1 . "%' ";
        $result = mysqli_query($con,$query);
        if ($result == null || mysqli_num_rows($result) == 0) {
            mysqli_close($con);
        }
        $result = mysqli_query($con,$query);

        while($row = mysqli_fetch_assoc($result)){
            echo"<tr>
            <td>" . $row['first_name'] . "</td>
            <td>" . $row['last_name'] . "</td>
            <td>" . get_hours_volunteered_by($row['id']) . "</td>
            <td>September,2023</td>
            </tr>";
        }
    }
        ?>
        </tbody>
        </table>
        <?php 
            require_once('database/dbPersons.php');
        ?>
        <div class="center_b"><a href="http://localhost/gwyneth/reports.php?venue=portland">
            <button class = "theB">New Report</button>
        </a></div>
        </main>
    </body>
</html>