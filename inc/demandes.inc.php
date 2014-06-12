<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();

	$parentId = $_SESSION['id'];


	$recherche = $_POST['recherche'];
	$infos = $_POST['infos'];
	$message = trim(strip_tags($_POST['message']));
	$status = 3;

	if(empty($message)) {
		$results['message'][]='Laissez donc un message au babysitter :)';
	}
	if ($recherche == 'notfound') {
		$babysitterId = $infos[0];
		$date_demande = date('Y-m-d');
		if(count($results) > 0) {
			echo json_encode($results);
		} else {
			$add_demande = $connexion->prepare('INSERT INTO
				nap_demandes(parentId, babysitterId, message, status, date_demande)
				VALUES(:parentId, :babysitterId, :message, :status, :date_demande)');
			$add_demande->execute(array(
				'parentId' => $parentId,
				'babysitterId' => $babysitterId,
				'message' => $message,
				'status' => $status,
				'date_demande' => $date_demande
				));

			$valid['status'] = 'ok';
			echo json_encode(($valid));
		}

	}elseif($recherche != 'notfound') {
		$children = $recherche[0];
		$date = $recherche[1];
		$debut = $recherche[2].$recherche[3];
		$fin = $recherche[4].$recherche[5];
		$adress = $recherche[6];
		$phone = $recherche[7];
		$babysitterId = $recherche[8];
		$childrenId = $recherche[9];
		$date_demande = $recherche[10];
		$enfants = $recherche[11];

		$dateSplit = explode('/', $date);
		$dateDay = $dateSplit[0];
		$dateMonth = $dateSplit[1];
		$dateYear = $dateSplit[2];

		$date = $dateYear.'-'.$dateMonth.'-'.$dateDay;


		$valid['infos_babysitting'][] = $recherche;

		$childId = $childrenId[0];
		for ($i=1; $i < count($childrenId); $i++) {
			$childId = $childId.','.$childrenId[$i];
		}

		// Vérifications


		if(count($results) > 0) {
			echo json_encode($results);
		}else{
			$add_demande = $connexion->prepare('INSERT INTO
				nap_demandes(parentId, babysitterId, datebs, adressbs, childrenId, phone, debut, fin, status, message, date_demande, children)
				VALUES(:parentId, :babysitterId, :datebs, :adressbs, :childrenId, :phone, :debut, :fin, :status, :message, :date_demande, :children)');
			$add_demande->execute(array(
				'parentId' => $parentId,
				'babysitterId' => $babysitterId,
				'datebs' => $date,
				'adressbs' => $adress,
				'childrenId' => $childId,
				'phone' => $phone,
				'debut' => $debut,
				'fin' => $fin,
				'status' => $status,
				'message' => $message,
				'date_demande' => $date_demande,
				'children' => $enfants
				));
			$valid['status'] = 'ok';
			echo json_encode(($valid));
		}
	}








?>