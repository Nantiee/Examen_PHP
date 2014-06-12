<?php
	session_start();
	include('connexion.inc.php');

	$userId = $_SESSION['id'];
	$account_type = $_SESSION['account_type'];

	if ($account_type == 1) {
		$search_notifs = $connexion->query("SELECT parentId, notif_type FROM nap_demandes WHERE babysitterID = ".$userId." AND notif_state = 1 AND notif_type = 1");
		$i = 0;
		while ($r = $search_notifs->fetch()) {

			$search_parent = $connexion->query("SELECT firstname, photo FROM nap_users WHERE id = ".$r['parentId']);
			$parent = $search_parent->fetch();

			$data[$i]['parent'] = $parent['firstname'];
			$data[$i]['photo'] = $parent['photo'];

			$data[$i]['notif_type'] = $r['notif_type'];

			$i = $i+1;
		}
	}elseif ($account_type == 2) {
		$search_notifs = $connexion->query("SELECT babysitterId, notif_type FROM nap_demandes WHERE parentID = ".$userId." AND notif_state = 1 AND (notif_type = 3 || notif_type = 2)");
		$i = 0;
		while ($r = $search_notifs->fetch()) {
			$search_babysitter = $connexion->query("SELECT firstname, photo FROM nap_users WHERE id = ".$r['babysitterId']);
			$babysitter = $search_babysitter->fetch();

			$data[$i]['babysitter'] = $babysitter['firstname'];
			$data[$i]['photo'] = $babysitter['photo'];

			$data[$i]['notif_type'] = $r['notif_type'];

			$i = $i+1;
		}
	}

	echo json_encode($data);









?>