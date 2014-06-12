<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();

	$parentId = $_SESSION['id'];


	$date = trim(strip_tags($_POST['date']));
	$heure_debut_dispo = trim(strip_tags($_POST['heure_debut_dispo']));
	$min_debut_dispo = trim(strip_tags($_POST['min_debut_dispo']));
	$heure_fin_dispo = trim(strip_tags($_POST['heure_fin_dispo']));
	$min_fin_dispo = trim(strip_tags($_POST['min_fin_dispo']));
	$children = $_POST['children'];
	$births = $_POST['births'];
	$lieu = trim(strip_tags($_POST['lieu']));



	$date_split = explode("/", $date);
	$day = $date_split[0];
	$month = $date_split[1];
	$year = $date_split[2];

	$date = $year.'-'.$month.'-'.$day;

// TROUVER AGE ENFANTS
	$year = date('Y');
	$month = date('m');
	$day = date('d');
	foreach ($births as $birthc) {
		$birth = explode('-', $birthc);
		$birthYear = $birth[0];
		$birthMonth = $birth[1];
		$birthDay = $birth[2];

		$age = $year-$birthYear;
		$diffMonth = $month-$birthMonth;
		if($diffMonth < 0) {
			$age = $age-1;
		}elseif($diffMonth == 0) {
			$diffDay = $day-$birthDay;
			if ($diffDay < 0) {
				$age = $age-1;
			}
		}
		$ages[] = $age;
	}
	$min_age = min($ages);
	$max_age = max($ages);
	$new_born = 1;
	if ($min_age == 0) {
		$new_born = 2;
	}

	// Vérifications
	if(empty($children)) {
		$results['child'][]='Vous n\'avez sélectionné aucun enfant';
	}
	if($heure_debut_dispo == '0' || $heure_fin_dispo == 00 || $date == 0) {
		$results['heure'][]='Vous n\'avez pas rempli tous les champs';
	}

	if(count($results) > 0) {
		echo json_encode($results);
	}else{
		$heure_debut = $heure_debut_dispo.$min_debut_dispo;
		$heure_fin = $heure_fin_dispo.$min_fin_dispo;

		$search_dispo = $connexion->prepare("SELECT babysitterId FROM nap_disponibilites
			INNER JOIN nap_users
			ON nap_disponibilites.datedispo = :datedispo
			AND nap_disponibilites.heure_debut <= :heure_debut
			AND nap_disponibilites.heure_fin >= :heure_fin
			AND nap_disponibilites.babysitterId = nap_users.id
			AND nap_users.age_debut <= :age_min
			AND nap_users.age_fin >= :age_max
			AND nap_users.new_born >= :new_born
			");
		$search_dispo = $connexion->prepare("SELECT babysitterId FROM nap_disponibilites
			INNER JOIN nap_users
			ON nap_disponibilites.datedispo = '".$date."'
			AND nap_disponibilites.heure_debut <= ".$heure_debut."
			AND nap_disponibilites.heure_fin >= ".$heure_fin."
			AND nap_disponibilites.babysitterId = nap_users.id
			AND nap_users.age_debut <= ".$min_age."
			AND nap_users.age_fin >= ".$max_age."
			AND nap_users.new_born >= ".$new_born."
			ORDER BY nap_users.last_connected DESC
			");
		$search_dispo->execute();
		while ($reponse = $search_dispo->fetch()) {
			$valid['babysitterId'][] = $reponse;


		}


		$valid['status'] = 'ok';
		echo json_encode($valid);
		// echo json_encode('ok');

	}














?>