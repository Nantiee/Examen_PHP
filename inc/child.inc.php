<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();

	$parentId = $_SESSION['id'];


	$form_type = trim(strip_tags($_POST['form_type']));
	$child_name = trim(strip_tags($_POST['child_name']));
	// $child_birth = trim(strip_tags($_POST['child_birth']));
	$birthDay = trim(strip_tags($_POST['birthDay']));
	$birthMonth = trim(strip_tags($_POST['birthMonth']));
	$birthYear = trim(strip_tags($_POST['birthYear']));
	$child_description = trim(strip_tags($_POST['child_description']));
	$thisY = date('Y');

	// VERIFICATIONS
	if(empty($birthDay) || empty($birthMonth) || empty($birthYear)) {
		// echo json_encode('La date de naissance n\'est pas valide');
		$results['birth'][]='La date de naissance est vide';
	}elseif(($birthDay > 31) || ($birthDay < 1) || ($birthMonth > 12) || ($birthMonth < 1)){
		$results['birth'][]='La date de naissance est invalide';
	}elseif($birthYear > $thisY){
		$results['birth'][]='Votre enfant n\'est pas encore né ?';
	}elseif($birthYear < $thisY-18) {
		$results['birth'][]='Votre enfant est bien fort âgé !';
	}else{
		$child_birth = $birthYear.'-'.$birthMonth.'-'.$birthDay;
	}

	if(empty($child_name)){
		$results['name'][]='Votre enfant n\'a pas de nom ?';
	}

	if(count($results) > 0) {
		echo json_encode($results);
	}else{

		if($form_type == 'edit'){

			$child_id = trim(strip_tags($_POST['child_id']));

			$edit_child = $connexion->prepare('UPDATE nap_children SET firstname = :firstname, birth = :birth, description = :description WHERE id = :id');
			$edit_child->execute(array(
				'firstname' => $child_name,
				'birth' => $child_birth,
				'description' => $child_description,
				'id' => $child_id
			));

			echo json_encode('edit ok');
		}elseif($form_type == 'new'){
			$add_child = $connexion->prepare("INSERT INTO nap_children (firstname, birth, description, parentId)
					VALUES (:firstname, :birth, :description, :parentId)");
			$add_child->execute(array(
				'firstname' => $child_name,
				'birth' => $child_birth,
				'description' => $child_description,
				'parentId' => $parentId
			));




			$id_child = $connexion->prepare("SELECT id FROM nap_children WHERE parentId = :parentId AND firstname = :firstname AND birth = :birth");
			$id_child->execute(array(
				'parentId' => $parentId,
				'firstname' => $child_name,
				'birth' => $child_birth
			));
			$reponseChild = $id_child->fetch();

				// Change Child ID dans table users
				// Récupérer enfants existants
				$search_childId = $connexion->prepare('SELECT enfants FROM nap_users WHERE id = :id');
				$search_childId->execute(array('id' => $parentId));
				$parentChild = $search_childId->fetch();
				$childId = $parentChild['enfants'];

				if(empty($childId)) {
					$childId = $reponseChild['id'];
				}else{
					$childId = $childId.','.$reponseChild['id'];
				}

				// Editer enfants ID
				$editChildId = $connexion->prepare('UPDATE nap_users SET enfants = :enfants WHERE id = :id');
				$editChildId->execute(array(
					'enfants' => $childId,
					'id' => $parentId
				));

			$data['parentId'] = $parentId;
			$data['child_name'] = $child_name;
			$data['child_birth'] = $child_birth;
			$data['childId'] = $reponseChild['id'];
			$data['reponse'] = 'ajout ok';
			echo json_encode($data);
		}
	}





	// $search_child = $connexion->prepare('SELECT * FROM children WHERE parentId ='.$parentId);
	// $search_child->execute(array($parentId));
	// while($reponseChild = $search_child->fetch()) {
	// 	$_SESSION['childId']=$reponseChild['id'];
	// 	$_SESSION['childParentId']=$reponseChild['parentId'];
	// 	$_SESSION['childFirstname']=$reponseChild['firstname'];
	// 	$_SESSION['childBirth']=$reponseChild['birth'];
	// 	$_SESSION['childDescription']=$reponseChild['description'];
	// }

	// $edit_date = $connexion->prepare('UPDATE users SET last_connected = :last_connected WHERE id = :user_id');
	// $edit_date->execute(array('last_connected'=>$last_connected, 'user_id'=>$reponse['id']));



	// echo json_encode('ok');



?>