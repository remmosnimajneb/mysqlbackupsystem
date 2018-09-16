<?php
/********************************
* Project: Web Server Backup System
* Code Version: 1.0
* Author: Benjamin Sommer
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

/*
* Auto Backup MySQL Databases - This file should be set as a Cron Job to run automatically
*/

//Force CLI
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('Invalid Request!');

//Import Functions.php
require 'admin/functions.php';

// Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

//Parse through all Records in BackupSRV DB and Backup All MySQL Tables, Email Output
$logger = "";

	//Select all Records which have Databases
	$dbs = "SELECT * FROM `websites` WHERE `databaseName` NOT LIKE 'NULL'";

	$stm = $con->prepare($dbs);
	$stm->execute();
	$dbArray = $stm->fetchAll();
	foreach($dbArray as $db){
		$explode = explode(',', $db['databaseName']);
		foreach ($explode as $dbExploded) {
			//Parse each DB and Dump logs to $logger

			$logger .= "[BACKUPSERVER]: Backing up Database: " . $dbExploded . "</br>";

			$options = array(
			        'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => 'token=' . $token . '&db=' . $dbExploded . '&path=' . $remote_backups_path,
			    )
			);

				//Get Response Back
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			$content = str_replace( array('\r\n','\n\r','\n','\r'), '<br>' , $result );
			
				//Dump to logger
			$logger .= $content;

			//Delete old Backups
			    $logger .= "<br />[BACKUP SERVER]: Checking to Delete old Backups: <br />";
			    $files = preg_grep('~^' . $dbExploded . '-.*\.(sql)$~', scandir($local_backups_path));
			    $len = count($files);
			    if($len > 2){
			        $logger .= "[BACKUP SERVER]: Old backups found!<br />";
			        $sliced_array = array_slice($files, 0, $len - 2);
			        foreach ($sliced_array as $backup) {
			            if(unlink($local_backups_path . $backup)){
			                $logger .= "[BACKUP SERVER]: Backup Deleted: " . $backup . "<br />";
			            }   
			        }
			    } else {
		    	$logger .= "<br />[BACKUP SERVER]: No Old Backups Found! <br />";
		    };
		} //End ForEach()
	} //End ForEach();

	//And Send Email!
try {
    $mail = new PHPMailer(true); // Passing `true` enables exceptions
    //Server settings
    $mail->SMTPDebug = 0;                       // Enable verbose debug output [0 is Disable, 2 is Show all]
 	$mail->isSMTP();                            
    $mail->Host = $stmp_host;                       
    $mail->SMTPAuth = $stmp_authentication;                     
    $mail->Username = $smtp_username;                      
    $mail->Password = $smtp_password;                   
    $mail->SMTPSecure = $smtp_encrytpion;                     
    $mail->Port = $smtp_port;                       

    //Recipients
    $mail->setFrom($email_from_addr);                         
    $mail->addAddress($email_to);   
    
    //Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = "Auto MySQL Backup";
    $mail->Body = "A backup on the Database was attempted, here is the output: <br /><br />" . $logger;
    $mail->send();
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo . '<br />';
};