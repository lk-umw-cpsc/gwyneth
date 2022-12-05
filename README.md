**Homebase is a web-based application that provides database and scheduling support
for Gwyneth's Gift Foundation, a local non-profit in Fredericksburg, VA.**

**Credits**: Homebase was originally developed in 2008 by Oliver Radwan, Maxwell Palmer, Nolan
McNair, Taylor Talmage, and Allen Tucker for the Ronald McDonald Houses in Maineand Rhode
Island. Since then, it has been significantly upgraded by other student teams and is
currently maintained by NPFI (https://npfi.org). The version of homebase contained within
this repository was built upon the NPFI legacy code, and its development was catered to the
needs of Gwyneth's Gift Foundation staff members.

**License**: GNU General Public License v3.0 (https://www.gnu.org/licenses/gpl.txt)

**Installation**: Homebase runs on an Apache/MySQL/PHP MAMP-server. For details on
installing and setting up a server for the project, visit the original Wiki
at https://github.com/megandalster/homebasedemo2017/wiki/Setting-Up-a-MAMP-Server.

Be sure your MAMP-server is running before installing Homebase. Also, be sure you
have your GitHub account ID and token. To obtain a GitHub token, you will need to
verify your email. Complete the following steps:

  1) Log into GitHub using your account ID and password.

  2) In the upper-right corner of any page, click your profile photo, then click Settings.

  3) In the "Access" section of the sidebar, click:\
     • Emails. (if it does not say *unverified*, then you have already verified your email)\
     • Under your email address, click Resend verification email.\
     • GitHub will send you an email with a link in it. After you click that link, you'll be
       taken to your GitHub dashboard and see a confirmation banner.

  4) In the upper-right corner of any page, click your profile photo, then click Settings\
     • In the left sidebar, click Developer settings.\
     • Now in the left sidebar, click Personal access tokens.

  5) Click Generate new token.\
     • Give your token a descriptive name.\
     • Select the Expiration drop-down menu, and click "no expiration date"\
     • Select the scopes, or permissions, you'd like to grant this token.
       (To use your token to access repositories from the command line, select repo.)

  6) Click Generate token. Be sure to save a copy of your GitHub token in a safe place. 
     You will be using it often whenever you commit code to your team's repository
     
Now, to install Homebase:

  1) Download the database homebasedb.sql.

  2) On your phpmyadmin page, create a MySQL database "homebasedb" on your server's\
     localhost with user = password = "homebasedb"\
     • Select User Accounts --> New User\
     • Fill in the boxes as shown (set password = homebasedb)

     ![img1](https://user-images.githubusercontent.com/73240609/205680150-b4d99607-ba54-4f17-9f98-34d53092724b.png)

     • Scroll to the bottom and hit **Go**\
     • Your new database "homebasedb" should now appear in the list of databases on the left of your phpmyadmin page.

  3) On your phpmyadmin page, import your downloaded database "homebasedb.sql" into your newly created database with the same name.\
     • Select "homebasedb" on the list of databases on the left.\
     • Select Import from the top menu, and choose the file homebasedb.sql from your Downloads as shown below:

     ![img2](https://user-images.githubusercontent.com/73240609/205687264-03868706-4e4d-4124-8058-7e72d092c401.png)

     • Scroll to the bottom and hit **Go**

  4) To set up for code sharing with your team, one member should mirror the github repository *jbbuechler/GwynethsGift* into your team's own github repository, *yourgithubaccount/yourteamsrepo*.\
     • Log into *yourgithubaccount*\
     • On github, create or access the blank repository *yourteamsrepo*\
     • In a terminal window, execute the following commands:
     > ‣cd /Applications/MAMP/htdocs (on Windows, it's c:\MAMP\htdocs)\
       ‣git clone https://github.com/jbbuechler/GwynethsGift \
       ‣cd GwynethsGift\
       ‣git push --mirror https://github.com/yourgithubaccount/yourteamsrepo \
       (You will need to enter your GitHub account ID and token here, not your password.)

  5) Each team member should then clone this mirror into their own local directory.\
     • In a terminal window, execute the following commands:
     > ‣cd /Applications/MAMP/htdocs (on Windows, it's c:\MAMP\htdocs)\
       ‣git clone https://github.com/yourgithubaccount/yourteamsrepo

  6) Each team member can then point their browser to http://localhost/yourteamsrepo/index.php.
     You should see the following Homebase login screen:

     ![img3](https://user-images.githubusercontent.com/73240609/205692074-25078416-2dac-4935-8cec-3b1e8722c3ea.png)
     
  7) Login with Username = Password = Admin7037806282 to get full administrative access to Homebase on your server.

**Usage**: Homebase can run stand-alone on a MAMP server such as this one, or it can be embedded in a Web page inside an "iFrame" such as the one shown at https://npfi.org/homebase-demo/.

     

     
