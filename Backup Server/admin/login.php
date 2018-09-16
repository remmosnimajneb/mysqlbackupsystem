<?php
/********************************
* Project: Web Server Backup System
* Code Version: 1.0
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

/*
* Login to Admin Panel
*/

//Require Functions Page
require 'functions.php';
	
//Start Sessions()
session_start();

//Assume User is logging in for first time and set the Authentication Session False
$_SESSION['backupsys_adminsession'] = false;

//If it's a post request, he tried logging in
$error = '';
if(isset($_POST['username']) && isset($_POST['password'])){
		//If credentials match (credentials set in functions.php), set Session, Go to admin.php
	if($_POST['username'] == $adminUsername && $_POST['password'] == $adminPassword){
		$_SESSION['backupsys_adminsession'] = true;
		header('Location: index.php');
	} else {
			//Else throw an error!
		$error = "Error! Authentication Failed. Please try again!";
	}
};

header('Content-type: text/html; charset=utf-8');

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Login | MySQL Backup System</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
		<div id="wrapper">
			<section id="main">
				<header>
					<h1>Login | MySQL Backup System</h1>
					<hr />
				</header>
				<?php echo $error; ?>
				<form action="login.php" method="POST">
					<input type="text" name="username" placeholder="Username" required="required" style="margin: auto;"><br />
					<input type="password" name="password" placeholder="Password" required="required" style="margin: auto;"><br />
					<input type="submit" name="Submit" value="Login">
				</form>
					<hr />
			</section>
			<!-- Footer -->
			<footer id="footer">
				<ul class="copyright">
					<li>&copy; <a href="https://sommertechs.com" target="_blank">Sommer Technologies</a> </li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
				</ul>
			</footer>
		</div>
		<script>
			if ('addEventListener' in window) {
				window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-preload\b/, ''); });
				document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
			}
		</script>
	</body>
</html>