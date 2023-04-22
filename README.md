# Gwyneth's Gift Volunteer Management System (VMS)
## Purpose
This project is the result of two semesters' worth of collaboration among UMW students. The goal of the project was to create a web application that the Gwyneth's Gift organization could utilize to make managing volunteers and organizing events easier. At-a-glance features include a web-based calendar of events, event sign up, volunteer registration & login system, reporting system, and basic notification system.

## Authors
The VMS is based on an old open source project named "Homebase". [Homebase](https://a.link.will.go.here/) was originally developed for the Ronald McDonald Houses in Maine and Rhode Island by Oliver Radwan, Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. A major overhaul to the existing system took place this semester, throwing out and restructuring many of the existing database tables. Very little original Homebase code remains.

Modifications to the original Homebase code were made by the previous semester's group of students. That team consisted of TEAM MEMBERS LIST HERE.

The major overhaul took place in the Spring 2023 semester. This team consisted of Lauren Knight, Zack Burnley, Matt Nguyen, Rishi Shankar, Alip Yalikun, and Tamra Arant. Every page and feature of the app was changed by this team.

## User types
There are three types of users within the VMS.
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
  * Top Performers
* Notification system, with notifications generated when
  * A user signs up for an event (sent to all staff members)
  * A user is assigned to an event by a staff member (sent to that volunteer)
  * A new event is created by a staff member (sent to all users)

## Video Tour of Features
A video demo of the system's features is available as an unlisted YouTube video. Please contact Dr. Polack for access to the video.

## Design Documentation
Several types of diagrams describing the design of the VMS, including sequence diagrams and use case diagrams, are available. Please contact Dr. Polack for access.

## License
The project remains under the GNU General Public License v3.0 (https://www.gnu.org/licenses/gpl.txt)

## "localhost" Installation
Below are the steps required to run the project on your local machine for testing purposes.
1. A LIST WILL GO HERE

## SiteGround Dashboard
Below are the steps needed to access the project's SiteGround dashboard, as well as some useful details about how to use SiteGround.

## Remoting into SiteGround via SSH
Below are the steps needed to gain terminal access to the SiteGround virtual machine.
1. STEPS HERE

## Potential Improvements
Below is a list of improvements that could be made to the system in subsequent semesters.
* The system could generate emails and send them to users (would require access to an @gwynethsgift.org email address)
* The notification system could be turned into a full-fledged messaging system
  * The existing dbMessages table is set up to allow this
* Reports
  * Additional reports could be added
  * Visual components could be added (graphs)
  * Client originally requested a reports dashboard with at-a-glance information available
* If a better webhosting option was chosen, file upload for pictures and documents would be better than having to use outside resources such as Google Docs or imgur for file upload
