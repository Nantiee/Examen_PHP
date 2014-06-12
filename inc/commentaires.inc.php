<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();

	$userId = $_SESSION['id'];


	$postType = trim(strip_tags($_POST['postType']));
	$idBabysitting = trim(strip_tags($_POST['idBabysitting']));
	$babysitterId = trim(strip_tags($_POST['babysitterId']));

	$today = date('Y-m-d');

	$check_champ = $connexion->query('SELECT babysittingId FROM nap_comments WHERE babysittingId = '.$idBabysitting);
	$comments = $check_champ->fetch();
	if ($comments == '') {
		if ($postType == 'commentaire'){
			$commentaire = trim(strip_tags($_POST['commentaire']));
			$ajout_comment = $connexion->prepare('INSERT INTO nap_comments(parentId, babysitterId, babysittingId, comment, date_comment)
			VALUES(:parentId, :babysitterId, :babysittingId, :comment, :date_comment)');
			$ajout_comment->execute(array(
				'parentId' => $userId,
				'babysitterId' => $babysitterId,
				'babysittingId' => $idBabysitting,
				'comment' => $commentaire,
				'date_comment' => $today
			));

		}elseif($postType == 'note'){
			$note = trim(strip_tags($_POST['note']));
			$ajout_comment = $connexion->prepare('INSERT INTO nap_comments(parentId, babysitterId, babysittingId, note)
			VALUES(:parentId, :babysitterId, :babysittingId, :note)');
			$ajout_comment->execute(array(
				'parentId' => $userId,
				'babysitterId' => $babysitterId,
				'babysittingId' => $idBabysitting,
				'note' => $note
			));
		}elseif($postType == 'favoris'){
			$fav = trim(strip_tags($_POST['fav']));
			echo($fav);
			$ajout_comment = $connexion->prepare('INSERT INTO nap_comments(parentId, babysitterId, babysittingId, favoris)
			VALUES(:parentId, :babysitterId, :babysittingId, :favoris)');
			$ajout_comment->execute(array(
				'parentId' => $userId,
				'babysitterId' => $babysitterId,
				'babysittingId' => $idBabysitting,
				'favoris' => $fav
			));
		}

	}elseif($comments != ''){
		if ($postType == 'commentaire'){
			$commentaire = trim(strip_tags($_POST['commentaire']));
			if(empty($commentaire)) {
				$results['commentaire'][]='Laissez donc un commentaire sur ce babysitting :)';
			}else{
				$add_comment = $connexion->prepare('UPDATE nap_comments SET comment = :comment, date_comment = :date_comment WHERE babysittingId = :babysittingId');
				$add_comment->execute(array(
					'comment' => $commentaire,
					'date_comment' => $today,
					'babysittingId' => $idBabysitting
					));
			}
			$edit_nb_com = $connexion->query('UPDATE nap_users SET nb_com = nb_com + 1 WHERE id = '.$babysitterId);
		}elseif($postType == 'note'){
			$note = trim(strip_tags($_POST['note']));
			$add_note = $connexion->prepare('UPDATE nap_comments SET note = :note WHERE babysittingId = :babysittingId');
			$add_note->execute(array(
				'note' => $note,
				'babysittingId' => $idBabysitting
				));
			}elseif($postType == 'favoris'){
				$fav = trim(strip_tags($_POST['fav']));
				$add_fav = $connexion->prepare('UPDATE nap_comments SET favoris = :favoris WHERE babysittingId = :babysittingId');
				$add_fav->execute(array(
					'favoris' => $fav,
					'babysittingId' => $idBabysitting
					));
			}
	}
	if($postType == 'note'){
		$note = trim(strip_tags($_POST['note']));
		$get_note = $connexion->query('SELECT avis_bs FROM nap_users WHERE id = '.$babysitterId);
		$note_bs = $get_note->fetch();


		if (empty($note_bs['avis_bs'])) {
			$newnote = $note;
		}elseif(!(empty($note_bs['avis_bs']))) {
			$newnote = $note_bs['avis_bs'].','.$note;
		}

		$edit_note = $connexion->prepare('UPDATE nap_users SET avis_bs = :avis_bs WHERE id = :id');
		$edit_note->execute(array(
			'avis_bs' => $newnote,
			'id' => $babysitterId
		));
	}

	if($postType == 'favoris'){
		$edit_fav_parent = $connexion->query('SELECT nb_fav FROM nap_users WHERE id = '.$userId);

		$r = $edit_fav_parent->fetch();

		if ($fav == 1) {

			if (empty($r['nb_fav'])) {
				$newfav = $babysitterId;
			}elseif(!(empty($r['nb_fav']))) {
				$newfav = $r['nb_fav'].','.$babysitterId;
			}

			$edit_fav_parent = $connexion->prepare('UPDATE nap_users SET nb_fav = :nb_fav WHERE id = :id');
			$edit_fav_parent->execute(array(
				'nb_fav' => $newfav,
				'id' => $userId
			));

			$edit_note = $connexion->query('UPDATE nap_users SET nb_fav = nb_fav + 1 WHERE id = '.$babysitterId);
		}elseif($fav == 0) {
			$favs = explode(',', $r['nb_fav']);

			$newfav_parent = '';
			for ($i=0; $i < count($favs); $i++) {
				if ($favs[$i] != $babysitterId) {
					if (empty($newfav_parent)) {
						$newfav_parent = $favs[$i];
					}else{
						$newfav_parent = $newfav_parent.','.$favs[$i];
					}
				}
			}

			$edit_fav = $connexion->prepare('UPDATE nap_users SET nb_fav = :nb_fav WHERE id = :id');
			$edit_fav->execute(array(
				'nb_fav' => $newfav_parent,
				'id' => $userId
			));

			$edit_note = $connexion->query('UPDATE nap_users SET nb_fav = nb_fav - 1 WHERE id = '.$babysitterId);


		}
	}

	$valid['status'] = 'ok';

	echo json_encode($valid);


?>