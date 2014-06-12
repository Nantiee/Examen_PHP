<?php
	session_start();
	$babysitterId = $_SESSION['id'];
	class Date{

		// $days = array('January', 'February', 'March');
		var $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
		var $months	= ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

		function getEvents($year){
			global $connexion;
			global $babysitterId;

			$search_babysitting = $connexion->prepare('SELECT * FROM nap_babysittings WHERE babysitterId = ?');
			$search_babysitting->execute(array($babysitterId));
			$r = array();

			// Je veux : $r[TIMESTAMP][id] = title

			while($d = $search_babysitting->fetch(PDO::FETCH_OBJ)){
				// $r[strtotime($d->datedispo)][$d->id] = $d->childrenName;
				// $r[strtotime($d->datedispo)]['id'] = $d->id;
				$r[strtotime($d->datebs)]['prénom'] = $d->children;
				// $r[strtotime($d->datedispo)]['heure_debut'] = $d->heure_debut;
				$h = str_split($d->debut, 2);
				$r[strtotime($d->datebs)]['heure_debut'] = $h[0].':'.$h[1];
				// $r[strtotime($d->datedispo)]['heure_fin'] = $d->heure_fin;
				$h = str_split($d->fin, 2);
				$r[strtotime($d->datebs)]['heure_fin'] = $h[0].':'.$h[1];
				$r[strtotime($d->datebs)]['place'] = $d->adressbs;
				$r[strtotime($d->datebs)]['phone'] = $d->phone;
				// $r[strtotime($d->datedispo)]['parentId'] = $d->parentId;


			}
			return $r;

		}

		function getDispos($year){
			global $connexion;
			global $babysitterId;

			$search_babysitting = $connexion->prepare('SELECT * FROM nap_disponibilites WHERE babysitterId = ?');
			$search_babysitting->execute(array($babysitterId));
			$r = array();

			// Je veux : $r[TIMESTAMP][id] = title

			while($d = $search_babysitting->fetch(PDO::FETCH_OBJ)){
				$r[strtotime($d->datedispo)]['heure_debut'] = $d->heure_debut;
				$r[strtotime($d->datedispo)]['heure_fin'] = $d->heure_fin;

			}
			return $r;
			print_r($r);

		}

		function getAll($year){
			$r = array();
			// $date = strtotime($year.'-01-01');
			// $y = date('Y', $date);
			// $m = date('m', $date);
			// $d = date('d', $date);
			// $w = date('N', $date);
			// $r[$y][$m][$d] = $w;
			// return $r;

			$date = new DateTime($year.'-01-01');
			while ($date->format('Y') <= $year) {
				$y = $date->format('Y');
				$m = $date->format('n');
				$d = $date->format('j');
				$w = $date->format('N');
				$r[$y][$m][$d] = $w;
				$date->add(new DateInterval('P1D'));
			}
			return $r;
		}
	}


?>