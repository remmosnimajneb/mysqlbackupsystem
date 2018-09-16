<?php
/********************************
* Project: Web Server Backup System
* Code Version: 1.0
* Author: Benjamin Sommer
* Email: ben@bensommer.net
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

/*
* Backup MySQL Databases
*/

//Include Config File
require 'config.php';

//Set Current Time and Date
define('DATE_NOW', date("Y-m-d\TH:i:sP"));


$logger = "";

//Check token, make sure were not just dumping for fun :)
if($_POST['token'] == $token){

	$logger .= "[REMOTE SERVER]: Starting MySQL Backup<br /><br />";
	$logger .= "[REMOTE SERVER]: Server Time Now: " . DATE_NOW . "<br /><br />";


	//Create file path 
    $filename = $_POST['path'] . '/' . $_POST['db'] .  '-' . DATE_NOW . '.sql';

    //Run MySQL Backup
    $logger .= "[REMOTE SERVER]: Running Backup <br /><br />";

    exec('mysqldump --user=' . $dbuser . ' --password=' . $dbpass . ' --host=' . $dbhost . ' ' . $_POST["db"] . ' > ' . $filename);

    $logger .= "[REMOTE SERVER]: Backup Complete<br /><br />";

	//Delete old Backups
    $logger .= "<br />[REMOTE SERVER]: Checking to Delete old Backups: <br />";
    $files = preg_grep('~^' . $_POST['db'] . '-.*\.(sql)$~', scandir($_POST['path']));
    $len = count($files);
    if($len > 2){
        $logger .= "[REMOTE SERVER:] Old backups found!<br />";
        $sliced_array = array_slice($files, 0, $len - 2);
        foreach ($sliced_array as $backup) {
            if(unlink($_POST['path'] . "/" . $backup)){
                $logger .= "[REMOTE SERVER]: Backup Deleted: mysql/" . $backup . "<br />";
            }   
        }
    }

    $logger .= "[REMOTE SERVER]: Starting FTP Transfer<br />";
    //FTP New Backup
    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    $login = ftp_login($ftp_conn, $ftp_username, $ftp_password);

    if (ftp_put($ftp_conn, $backup_server_backup_path . $_POST['db'] .  "-" . DATE_NOW . ".sql", $filename, FTP_ASCII)){
      $logger .= "[REMOTE SERVER]: Successfully uploaded $filename.<br />";
    } else{
      $logger .= "[REMOTE SERVER]: Error uploading $filename.<br />";
    }

    // Close Connection
    ftp_close($ftp_conn);

    //Dump Output
	echo json_encode($logger);
	
}else{
	die ("Invalid request!");	
}
?>
