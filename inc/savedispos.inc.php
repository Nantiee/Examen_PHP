<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();

	$babysitterId = $_SESSION['id'];


	$dates = $_POST['dates'];
	$heure_debut_dispo = trim(strip_tags($_POST['heure_debut_dispo']));
	$min_debut_dispo = trim(strip_tags($_POST['min_debut_dispo']));
	$heure_fin_dispo = trim(strip_tags($_POST['heure_fin_dispo']));
	$min_fin_dispo = trim(strip_tags($_POST['min_fin_dispo']));
	$year = trim(strip_tags($_POST['year_dispo']));




	// Vérifications
	if($heure_debut_dispo == '0' || $heure_fin_dispo == 00) {
		$results['heure'][]='Veuillez indiquer vos heures';
		echo json_encode($results);
	}else{
		$dispo_heure_debut = $heure_debut_dispo.$min_debut_dispo;
		$dispo_heure_fin = $heure_fin_dispo.$min_fin_dispo;
		foreach($dates as $date) {
			$date_split = explode(' ', $date);
			$day = $date_split[1];
			$month = $date_split[2];
				if($month=='Janvier'){$month='01';}
				elseif($month=='Février'){$month='02';}
				elseif($month=='Mars'){$month='03';}
				elseif($month=='Février'){$month='04';}
				elseif($month=='Février'){$month='05';}
				elseif($month=='Juin'){$month='06';}
				elseif($month=='Juillet'){$month='07';}
				elseif($month=='Août'){$month='08';}
				elseif($month=='Septembre'){$month='09';}
				elseif($month=='Octobre'){$month='10';}
				elseif($month=='Novembre'){$month='11';}
				elseif($month=='Décembre'){$month='12';}

			$date = $year.'-'.$month.'-'.$day;

			$add_dispo = $connexion->prepare("INSERT INTO nap_disponibilites
				(datedispo, heure_debut, heure_fin, babysitterId)
				VALUES (:datedispo, :heure_debut, :heure_fin, :babysitterId)");
			$add_dispo->execute(array(
				'datedispo' => $date,
				'heure_debut' => $dispo_heure_debut,
				'heure_fin' => $dispo_heure_fin,
				'babysitterId' => $babysitterId
			));
		}

		echo json_encode('ok');
	}














?>