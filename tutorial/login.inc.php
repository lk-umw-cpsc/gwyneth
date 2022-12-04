<?PHP
/*
 * Copyright 2015 by Adrienne Beebe, Connor Hargus, Phuong Le, 
 * Xun Wang, and Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
session_start();
session_cache_expire(30);
?>
<html>
<head>
<title>RMH Homebase login help</title>
</head>
<body>
	<div align="left">
		<p>
			<strong> Signing in and out of the System</strong>
		</p>
		
		<p>Access to Gwyneth's Gift Homebase requires a Username and a Password. The form
			looks like this:
		</p>
		
		<p></p>
		
		
		<table align="center">
			<tr>
				<td>Username:</td>
				<td><input type="text" name="user" tabindex="1"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="pass" tabindex="2"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="Login"
					value="Login"></td>
			</tr>
		</table>
		<p>
			If you are a <i>new user</i>, you can sign in by using the Username
			<strong>guest</strong> and leaving the Password field empty.
		</p>
		<p>
		    Once you sign in, the page will look something like this:
		    <a
            		href="tutorial/screenshots/guestLoginPage.JPG" class="image"
            		title="guestLoginPage.JPG"
            		target="tutorial/screenshots/guestLoginPage.JPG">
            		&nbsp;&nbsp;&nbsp;&nbsp;<img
            		src="tutorial/screenshots/guestLoginPage.JPG" width="10%"
            		rel="popover" data-img="tutorial/screenshots/guestLoginPage.JPG"
            		border="1px" align="middle"> </a>
		</p>
		<p>
		    There will be a message prompting you to click the <strong>Apply</strong>
		    link in the page banner. From there you will be able to fill out and
		    submit an on-line form to create an account. Once you submit the form,
		    you will have to wait for an admin to activate your account in order
		    for you to log in.
		</p>
		<p>
			If you are a <i>volunteer or admin</i> with an active account, your Username is your
			first name followed by your phone number with no spaces.
		</p>
		<ul>
			<li>For example, if your first name is John and your phone number is
				(401)-123-4567, your Username would be <strong>John4011234567</strong>.
			
			<li>Remember that your Username and Password are <em>case-sensitive</em>.
			
			<li>If you mistype your Username or Password, the following error
				message will appear:
				<p class="error">
					Error: invalid username/password<br />if you cannot remember your
					password, ask the Volunteer Coordinator to reset it for you.
				</p>
				<p>At this point, you can retry entering your Username and Password
					(if you think you may have mistyped them).
                </p>
		</ul>
		<p>
			Remember to <strong>logout</strong> when you are finished using the Gwyneth's Gift
			Homebase.
        </p>
</body>
</html>

