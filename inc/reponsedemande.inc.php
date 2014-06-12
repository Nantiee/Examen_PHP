<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();

	$babysitterId = $_SESSION['id'];

	$reponse_demande = trim(strip_tags($_POST['reponse_demande']));
	$message_reponse = trim(strip_tags($_POST['message_reponse']));
	$demande_id = trim(strip_tags($_POST['demande_id']));

	$today = date('Y-m-d');
	if ($reponse_demande == 'valider') {
		$status = 2;
		$notif_type = 2;
	}elseif ($reponse_demande == 'refuser') {
		$status = 1;
		$notif_type = 3;
	}


	// Vérifications
	if(empty($message_reponse)) {
		$results['message'][]='Laissez donc un message au parent :)';
	}

	if(count($results) > 0) {
		echo json_encode($results);
	} else {
		$edit_demande = $connexion->prepare('UPDATE nap_demandes SET status = :status, reponse_babysitter = :reponse_babysitter, date_reponse = :date_reponse, notif_type = :notif_type, notif_state = :notif_state WHERE id_demandes = :id_demandes');
		$edit_demande->execute(array(
			'status' => $status,
			'reponse_babysitter' => $message_reponse,
			'id_demandes' => $demande_id,
			'date_reponse' => $today,
			'notif_type' => $notif_type,
			'notif_state' => '1'
			));
		$valid['reponse_demande'] = $status;
		$valid['status'] = 'ok';

		if ($status == 2) {
			$add_nextbs = $connexion->query('INSERT INTO nap_babysittings SELECT * FROM nap_demandes WHERE id_demandes='.$demande_id);
		}

		echo json_encode($valid);

	}











?>