<?php
/********************************
* Project: Web Server Backup System
* Code Version: 1.0
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

/**
* Functions Page
*/

//MySQL Connection
$con = new PDO("mysql:host=;dbname=", "", "");

//Admin Panel Login Credentials
$adminUsername = "";
$adminPassword = "";

//Token - Make sure this matches the Remote Server Token!
$token = "";

//Remote Server URL of mysqlbackup.php
$url = "/mysqlbackup.php";

//Path that backups are being stored on 
$local_backups_path = "";

//Remote Path to dump backups
$remote_backups_path = "";

//Email Config
$stmp_host = ""; //SMTP URL
$stmp_authentication = ; //SMTP Authentication: [true, false]
$smtp_username = "";
$smtp_password = "";
$smtp_encrytpion = ""; //[tls, ssl]
$smtp_port = ;

$email_from_addr = ""; //Email From Address
$email_to = ""; //Send email to:              

?>