<?php
/*
 * Copyright 2015 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook, 
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

	session_start();
	session_cache_expire(30);
?>
<html>
	<head>
		<title>
			About
		</title>
		<link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" />
	</head>
	<body>
		<div class="container-fluid">
			<?PHP include('header.php');?>
			<div id="content">
				<p class="text-center"><strong>About Gwyneth's Gift Foundation</strong><br /><br />
				Gwyneth’s Gift Foundation is devoted to making a difference in the community and the lives of those within. We hope that through our work,
				we can serve as a catalyst for increasing the survival rate of those suffering from an out-of-hospital cardiac arrest because they received
				immediate life-saving measures from a member within their community.</p>
				
				<p class="text-center">Gwyneth’s Gift Foundation is a 501(c)(3) tax-exempt organization. Gwyneth’s Gift Foundation is Guidestar Gold Transparency, a member of
				the Rappahannock United Way Local Government Campaign (LGC) and the Commonwealth of Virginia Campaign (CVC).
 
				<p class="text-center">Gwyneth’s Gift Foundation was founded in 2015 by Joel and Jennifer Griffin in honor of their oldest daughter, Gwyneth. Through the Foundation’s
				work, Gwyneth’s spirit of caring, compassion, and community lives on as we create a world where everyone can save a life.
				</p>
				
 				<p class="text-center"><b>Our Vision</b><br /><br />
				To create a Culture of Action where communities are educated, confident and empowered to save the lives of individuals suffering from cardiac arrest.
                </p>
                <p class="text-center"><b>Our Mission</b><br /><br />
				To raise awareness of Cardiopulmonary Resuscitation (CPR) and the use of Automated External Defibrillators (AEDs).
				</p>
				
			</div>
		<?PHP include('footer.inc');?>
		</div>
	</body>
</html>
