<!DOCTYPE HTML>
<html>
	<head>
		<title>MySQL Backup System</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<section id="main">
						<header>
							<h1>MySQL Backup System</h1>
								<hr />
						</header>
							<p>
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
* Manually Call a Web Backup
* Don't delete extra Backup on a Manual Backup, leave it for the nightly cleanup
*/

//Require Functions Page
require 'functions.php';

// Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

//Start Session and check authentication
session_start();
if($_SESSION['backupsys_adminsession'] != true){
	header('Location: login.php');
	die();
};

//First find out what site we're backing up
$domain = $_GET['name'];
$databases = array();
$filePath;
$logger = "";

$sql = "SELECT * FROM `websites` WHERE `domainName` = '" . $domain . "'";
$stm = $con->prepare($sql);
$stm->execute();
$records = $stm->fetchAll();

foreach($records as $row){
	$databases = explode(',', $row['databaseName']);
	$filePath = $row['filePath'];
}

//Backup MySQL DataBases
//Check we have any to backup!
	if(count($databases) > 1){

		foreach ($databases as $db) {
			//Parse each DB and Dump logs to $logger

					$logger .= "[BACKUPSERVER]: Backing up Database: " . $db . "</br>";

					$options = array(
					        'http' => array(
					        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					        'method'  => 'POST',
					        'content' => 'token=' . $token . '&db=' . $db . '&path=' . $remote_backups_path,
					    )
					);

						//Get Response Back
					$context  = stream_context_create($options);
					$result = file_get_contents($url, false, $context);
					$content = str_replace( array('\r\n','\n\r','\n','\r'), '<br>' , $result );
					
						//Dump to logger
					$logger .= $content;
		}
	
	$logger .= "[BACKUPSERVER]: End MySQL Backup<br />";
	
	}//End If()


//Send Email
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
    $mail->Subject = "Server Backup Status";
    $mail->Body = "A backup on the webserver was attempted, here is the output: <br /><br />" . $logger;
    $mail->send();
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo . '<br />';
};

//Now Redirect to message.php with this information.
//header('Location: message.php?raw=' . $logger);
echo $logger;

?>
						</p>
							<hr />
							<a href="index.php"><button>Home</button></a>
					</section>

				<!-- Footer -->
			<footer id="footer">
				<ul class="copyright">
					<li>&copy; <a href="https://sommertechs.com" target="_blank">Sommer Technologies</a> </li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
				</ul>
			</footer>

			</div>

		<!-- Scripts -->
			<!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
			<script>
				if ('addEventListener' in window) {
					window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-loading\b/, ''); });
					document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
				}
			</script>

	</body>
</html>