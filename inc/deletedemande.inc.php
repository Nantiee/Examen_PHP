<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();

	$babysitterId = $_SESSION['id'];

	$demande_id = trim(strip_tags($_POST['demande_id']));

	$delete_demande = $connexion->query("DELETE FROM nap_demandes WHERE id_demandes = $demande_id");


	echo json_encode("ok");











?>