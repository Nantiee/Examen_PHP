<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();

	$parentId = $_SESSION['id'];


	$parent1 = trim(strip_tags($_POST['parent1']));
	$phoneparent1 = trim(strip_tags($_POST['phoneparent1']));
	$parent2 = trim(strip_tags($_POST['parent2']));
	$phoneparent2 = trim(strip_tags($_POST['phoneparent2']));

	$urgence1 = trim(strip_tags($_POST['urgence1']));
	$urgencephone1 = trim(strip_tags($_POST['urgencephone1']));
	$urgence2 = trim(strip_tags($_POST['urgence2']));
	$urgencephone2 = trim(strip_tags($_POST['urgencephone2']));

	$docteurname = trim(strip_tags($_POST['docteurname']));
	$docteurphone = trim(strip_tags($_POST['docteurphone']));
	$docteuradress = trim(strip_tags($_POST['docteuradress']));

	$important = trim(strip_tags($_POST['important']));

	// Vérifications

	if(count($results) > 0) {
		echo json_encode($results);
	} else {
		$test = $connexion->prepare('UPDATE nap_users SET parent1 = :parent1, phoneparent1 = :phoneparent1, parent2 = :parent2, phoneparent2 = :phoneparent2, urgence1 = :urgence1, urgencephone1 = :urgencephone1, urgence2 = :urgence2, urgencephone2 = :urgencephone2, docteurname = :docteurname, docteurphone = :docteurphone, docteuradress = :docteuradress, important = :important  WHERE id = :id');
		$test->execute(array('parent1' => $parent1, 'phoneparent1' => $phoneparent1, 'parent2' => $parent2, 'phoneparent2' => $phoneparent2, 'urgence1' => $urgence1, 'urgencephone1' => $urgencephone1, 'urgence2' => $urgence2, 'urgencephone2' => $urgencephone2, 'docteurname' =>$docteurname, 'docteurphone' =>$docteurphone, 'docteuradress' => $docteuradress, 'important' => $important, 'id' => $parentId));
		echo json_encode('ok');
	}










?>