<?php 
	session_start();
	unset($_SESSION);
	session_destroy();

	// setcookie('auth', '', time() - 3600,  '/', 'tfe.alexiswalravens.be', false, true);	
	header('location: ../inscription.php');

	exit;
 ?>