<?php
	session_start();
	include('connexion.inc.php');

	$userId = $_SESSION['id'];
	$account_type = $_SESSION['account_type'];
	if ($account_type == 1) {
		$userType = 'babysitter';
	}elseif ($account_type == 2) {
		$userType = 'parent';
	}
	extract($_POST);


	$vue_notif = 1;
	$vue_notif = trim(strip_tags($_POST['vue_notif']));
	// SELECT babysitterId, parentId, notif_type FROM nap_demandes WHERE ".$userType."ID = ".$userId." AND notif_state = 1");

	$edit_fav_parent = $connexion->prepare("UPDATE nap_demandes SET notif_state = :notif_state WHERE ".$userType."ID = ".$userId);
	$edit_fav_parent->execute(array(
		'notif_state' => $vue_notif
	));




?>