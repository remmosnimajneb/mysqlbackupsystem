# MySQL Backup System

Project: Web Server Backup System
Code Version: 1.0
Author: Benjamin Sommer
Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)

## Table of Contents:
1. Overview
2. How it works
3. Requirements & Install Instructions
4. Things to know before using!
5. Updates to come

## SECTION 1 - OVERVIEW

So I have this server (cool right?) and it's got a whole bunch of these things called websites on it. And a bunch of these sites have MySQL Databases holding their data. One thing I didn't have was backups (Really Bad.....I know, I know). So I decided at least for the MySQL I *need* to setup something to auto backup the Databases. But you see, I didn't think it was good enough to backup the MySQL and dump it to a directory, it ALSO has to be able to FTP it over to my backup server for redundancy (all or nothing as it's called, right?). So this is it. A script/interface that backs up your MySQL databases on a remote server however often you want and FTP's them over to your backupserver. Updates to come. Really Hopefully. I mean we'll see....I guess.

This program is 100% open source, feel free to do anything you want to it! Just make sure to remember to give me some credit and make sure to ShareAlike! (For the full licence and fine text stuff see creativecommons.org/licenses/by-sa/4.0/).

Also while speaking about giving credit, the HTML theme comes from html5up.net made by @ajlkn (twitter.com/ajlkn). This guy makes siiiiick stuff, make sure to check him out at html5up.net (Free HTML5 Stunning Mobile Friendly Website Templates (Free!)), carrd.co (An Incredible website builder that looks amazing and works even better!) and his Twitter page (@ajlkn).

## SECTION 2 - HOW IT WORKS:
So here's how it works.
1. You have a Remote Server and Backup Server
2. The program stores in a database on the Backup Server a list of all the Databases on the Remote Server to backup
3. Every n times per x (It's arbitrary...Cron job) a script is called which parses throught the Database and calls the script on the remote server to backup each Database and then FTP it over to the backup server.
4. Program also includes an Admin UI on the backup server to show all current backups and ability to pull a manual backup

## SECTION 3 - REQUIRMENTS & INSTALL INSTRUCTIONS
	
Requirments:

- A web server as a Backup Server, that can be accessed over the internet for use out of Local Area Network
- A web server as a Remote Server, that can be accessed over the internet for use out of Local Area Network
- MySQL with PDO type PHP Extention (!Important!)
- PHP
- That's it

Aight, let's go! Let's install this thing already!!

Install: 

Here's how to install this:
On your Backup Server:
1. Create a new MySQL Database on your server
2. Import or run the SQL commands to setup the system on the server - (File: SQLInstall.sql)
3. Open the functions file (File: functions.php) in your favorite text editor (h/t to mine Sublime Text 3) and add in all the info, (MySQL Login, SMTP Settings, Server Token and the other config settings)
4. Move all the files to your public directory on the server (Can exclude this file and SQLInstall.sql, everything else required) from the Backup Server Folder
5. Set via Crontab or on Windows Task Scheduler to run automysqlbackup.php to run however often you want.

On the remote server:
1. Open the config.php file and insert all the various config options
2. Stick the config.php and automysqlbackup.php file somewhere in your webroot


## SECTION 4 - THINGS TO KNOW!

Ok so the thing about this is it's kinda half baked idea, so....
1. In order to actually add Databases to backup, you need to manually insert them into the SQL (PHPMyAdmin or something else)
2. There is also no files backup, something I want to implement at some point but....until then....
So just know that before you use this....

## SECTION 6 - FUTURE UPDATES LIST

1. GUI to add Databases to System
2. Web Files Backup (ZIP Folder and FTP)
3. Instead of making a new connection each time, send a list of MySQL DB's and do it all in one shot