<html>
<head>
<link rel="stylesheet" href="lib/jquery-ui.css" />
<link rel="stylesheet" href="lib/jquery.timepicker.css" />
<link rel="stylesheet" href="styles.css" type="text/css" />
<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
<script src="lib/jquery.timepicker.js"></script>
<script>
$(function() {
	$( "#date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});
	$( "#start_time" ).timepicker({'minTime': '9:00am', 'maxTime': '9:00pm'});
	$( "#end_time" ).timepicker({'minTime': '9:00am', 'maxTime': '9:00pm'});
	$( "#target" ).scroll();
});
</script>
</head>
<body>
<div>
	<p>
	<form method="post">
		<p> <b>Example Datepicker and Timepicker Elements</b>
		<br> Today's date and time: <?php date_default_timezone_set ("America/New_York"); echo Date("F d, Y g:ia");?></p>
	<table>	<tr>
		<td valign="top"> Select Date and Time: 
			<p> date : <input name = "date" type="text" id="date">
				start time : <input name = "start_time" type="text" id="start_time">
				end time : <input name = "end_time" type="text" id="end_time"></p>
		</td>
	</tr></table>
	</form>
</div>
<div id="target" style="overflow: scroll; width: 600px; height: 200px;">
<p> <b>Example Scrollbar Element -- see http://api.jquery.com/scroll/ for details</b>
<p>
<?php for ($i=0;$i<100;$i++) {
         echo "<br>"; 
         for ($j=0;$j<100;$j++)
             echo $i*$j."&nbsp;&nbsp;";
}  
?>
</p>
</div>
</body>
</html>


