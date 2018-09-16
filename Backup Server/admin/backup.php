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
* Index Page
*/

//Require Functions Page
require 'functions.php';

//Start Session and check authentication
session_start();
if($_SESSION['backupsys_adminsession'] != true){
	header('Location: login.php');
	die();
};
?>
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
						<table>
						  <caption>Available Sites to Backup: </caption>
						  <thead>
						    <tr>
						      <th scope="col">Website Name</th>
						      <th scope="col">SQL Databases</th>
						      <th scope="col">Remote Server File Path</th>
						      <th scope="col">Backup</th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php
						  		$sql = "SELECT * FROM `websites`";
								$stm = $con->prepare($sql);
								$stm->execute();
								$records = $stm->fetchAll();
								foreach($records as $row){
									echo "<tr>";
									echo "<td data-label='Website Name'>" . $row['domainName'] . "</td>";
									echo "<td data-label='SQL Databases'>" . $row['databaseName'] . "</td>";
									echo "<td data-label='File Path'>" . $row['filePath'] . "</td>";
									echo "<td data-label='Backup'><a href=manualBackup.php?name=" . $row['domainName'] . ">Backup</a></td>";
									echo "</tr>";	
								}
						  	?>
						  </tbody>
						</table>
							<hr />
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