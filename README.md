# Gwyneth's Gift Volunteer Management System (VMS)
## Purpose
This project is the result of two semesters' worth of collaboration among UMW students. The goal of the project was to create a web application that the Gwyneth's Gift organization could utilize to make it easier to manage volunteers and organize events. At-a-glance features include a web-based calendar of events, event sign up, volunteer registration & login system, reporting system, and basic notification system.

## Authors
The VMS is based on an old open source project named "Homebase". [Homebase](https://a.link.will.go.here/) was originally developed for the Ronald McDonald Houses in Maine and Rhode Island by Oliver Radwan, Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker.

Modifications to the original Homebase code were made by the Fall 2022 semester's group of students. That team consisted of Jeremy Buechler, Rebecca Daniel, Luke Gentry, Christopher Herriott, Ryan Persinger, and Jennifer Wells.

A major overhaul to the existing system took place during the Spring 2023 semester, throwing out and restructuring many of the existing database tables. Very little original Homebase code remains. This team consisted of Lauren Knight, Zack Burnley, Matt Nguyen, Rishi Shankar, Alip Yalikun, and Tamra Arant. Every page and feature of the app was changed by this team.

## User Types
There are three types of users (also referred to as 'roles') within the VMS.
* Volunteers
* Admins
* SuperAdmins

Volunteers can only access the calendar, modify their own account details, or sign up for events.

Admin and SuperAdmins have the ability to manage users, generate reports, assign users to events, reset user passwords, and modify a user's status.

Only a SuperAdmin can modify a user's access level.

Users of any type can have their status changed to Inactive to prevent them from signing up for events. Inactive users will also stop appearing in the list of volunteers available to be assigned. Additionally, the reports page allows staff members to filter out inactive users.

There is also a root admin account with username 'vmsroot'. The default password for this account is 'vmsroot', but it must be changed upon initial log in. This account has hardcoded SuperAdmin privileges but cannot be assigned to events and does not have a user profile. It is crucial that this account be given a strong password and that the password be easily remembered, as it cannot easily be reset. This account should be used for system administration purposes only.

## Features
Below is an in-depth list of features that were implemented within the system
* User registration and log in
* Dashboard
* User Management
  * Change own password
  * View volunteer hours (print-friendly)
  * Modify profile
  * Modify user status (Admin/SuperAdmin only)
  * Modify user role (AKA access level) (SuperAdmin only)
  * Reset password (Admin/SuperAdmin only)
  * User search (Admin/SuperAdmin only)
* Events and Event Management
  * Calendar with event listings
  * Calendar day view with event listings
  * Event search
  * Event details page
  * Volunteer event sign up
  * Assign Volunteer to event (Admin/SuperAdmin only)
  * Attach event training media (links, pictures, videos) (Admin/SuperAdmin only)
  * Attach post-event media (links, pictures, videos) (Admin/SuperAdmin only)
  * View Event Roster (Admin/SuperAdmin only) (print-friendly)
  * Modify event details (Admin/SuperAdmin only)
  * Create new event listing (Admin/SuperAdmin only)
  * Delete event (Admin/SuperAdmin only)
* Reports (Admin/SuperAdmin only) (print-friendly)
  * General Volunteer Report
  * Total Volunteer Hours
  * Individual Volunteer Hours
  * Top Performers
* Notification system, with notifications generated when
  * A user signs up for an event (sent to all staff members)
  * A user is assigned to an event by a staff member (sent to that volunteer)
  * A new event is created by a staff member (sent to all users)

### Video Tour of Features
A video demo of the system's features is available as an unlisted YouTube video. Please contact Dr. Polack for access to the video.

## Design Documentation
Several types of diagrams describing the design of the VMS, including sequence diagrams and use case diagrams, are available. Please contact Dr. Polack for access.

## "localhost" Installation
Below are the steps required to run the project on your local machine for development and/or testing purposes.
1. [Download and install XAMPP](https://www.apachefriends.org/download.html)
2. Open a terminal/command prompt and change directory to your XAMPP install's htdocs folder
  * For Mac, the htdocs path is `/Applications/XAMPP/xamppfiles/htdocs`
  * For Ubuntu, the htdocs path is `/opt/lampp/htdocs/`
  * For Windows, the htdocs path is `C:\xampp\htdocs`
3. Clone the VMS repo by running the following command: `git clone https://github.com/lk-umw-cpsc/gwyneth.git`
4. Start the XAMPP MySQL server and Apache server
5. Open the PHPMyAdmin console by navigating to [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)
6. Create a new database named `homebasedb`. With the database created, navigate to it by clicking on it in the lefthand pane
7. Import the `vms.sql` file located in `htdocs/gwyneth/sql` into this new database
8. Create a new user by navigating to `Privileges -> New -> Add user account`
9. Enter the following credentials for the new user:
  * Name: `homebasedb`
  * Hostname: `Local`
  * Password: `homebasedb`
  * Leave everything else untouched
10. Navigate to [http://localhost/gwyneth/](http://localhost/gwyneth/) 
11. Log into the root user account using the username `vmsroot` with password `vmsroot`
12. Change the root user password to a strong password

Installation is now complete.

## Reset root user credentials
In the event of being locked out of the root user, the following steps will allow resetting the root user's login credentials:
1. Using the PHPMyAdmin console, delete the `vmsroot` user row from the `dbPersons` table
2. Clear the SiteGround dynamic cache [using the steps outlined below](#clearing-the-siteground-cache)
3. Navigate to gwyneth/insertAdmin.php. You should see a message that says `ROOT USER CREATION SUCCESS`
4. You may now log in with the username and password `vmsroot`

## Platform
Dr. Polack chose SiteGround as the platform on which to host the project. Below are some guides on how to manage the live project.

### SiteGround Dashboard
Access to the SiteGround Dashboard requires a SiteGround account with access. Access is managed by Dr. Polack.

### Remoting into SiteGround via SSH
Terminal access is required to easily update the code on the live website.

Below are the steps needed to gain terminal access to the SiteGround virtual machine.
1. Within the SiteGround dashboard, click "Devs -> SSH Keys Manager"
2. Create a new SSH key using the form
  * Provide a memorable string as the Key Name
  * Provide a strong password. This cannot be retrieved, so be sure to remember it
3. The new key will appear below the form, under 'Manage SSH Keys'. Click the '...' under Actions and choose 'Private Key'

The following steps are for Mac and Linux users:

5. Copy the key and save it somewhere on your system, such as your home directory. Remember the filename you save it as
6. Click '...' under Actions again. This time, choose 'SSH Credentials'
7. Note the hostname, username, and port number
8. Run the following command: `ssh -i KEYFILENAME USERNAME@HOSTNAME -pPORT`, with `KEYFILENAME`, `USERNAME`, `HOSTNAME`, and `PORT` being replaced with the information you obtained in the steps above
9. Enter the password for the account that you created in step 3
10. You now have SSH access into SiteGround
11. The repo is located in `~/www/SITEGROUNDURL/public-html/gwyneth/`, where `SITEGROUNDURL` is the domain of the SiteGround website

On PC, use the following tutorial to set up SSH access:
[https://www.siteground.com/tutorials/ssh/putty/](https://www.siteground.com/tutorials/ssh/putty/)

### Clearing the SiteGround cache
There may occasionally be a hiccup if the caching system provided by SiteGround decides to cache one of the application's pages in an erroneous way. The cache can be cleared via the Dashboard by navigating to Speed -> Caching on the lefthand side of the control panel, choosing the DYNAMIC CACHE option in the center of the screen, and then clicking the Flush Cache option with a small broom icon under Actions.

## External Libraries and APIs
The only outside library utilized by the VMS is the jQuery library. The version of jQuery used by the system is stored locally within the repo, within the lib folder. jQuery was used to implement form validation and the hiding/showing of certain page elements.

## Potential Improvements
Below is a list of improvements that could be made to the system in subsequent semesters.
* The system could generate emails and send them to users (would require access to an @gwynethsgift.org email address)
  * For user email verification
  * For password reset
  * For nofications/messages received (see below)
* The notification system could be turned into a full-fledged messaging system
  * The existing dbMessages table is set up to allow this
* Reports
  * Additional reports could be added
  * Visual components could be added (graphs)
  * Client originally requested a reports dashboard with at-a-glance information available
* If a better webhosting option was chosen, file upload for pictures and documents would be better than having to use outside resources such as Google Docs or imgur for file upload
* A password complexity policy could be implemented. As it stands, there are no minimum password complexity requirements

## License
The project remains under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl.txt).

## Acknowledgements
Thank you to Dr. Polack and Veronica for the chance to work on this exciting project. A lot of love went into making it!
