<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();

	$babysitterId = $_SESSION['id'];


	$date = $_POST['date'];
	$day = trim(strip_tags($_POST['day']));
	$month = trim(strip_tags($_POST['month']));
	$year = trim(strip_tags($_POST['year']));

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

	$delete_dispo = $connexion->prepare("DELETE FROM nap_disponibilites WHERE datedispo = :datedispo AND babysitterId = :babysitterId");
	$delete_dispo->execute(array(
    'datedispo' => $date,
    'babysitterId' => $babysitterId));

	echo json_encode('ok');















?>