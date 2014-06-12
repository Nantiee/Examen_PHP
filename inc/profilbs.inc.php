<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();
	$babysitterId = $_SESSION['id'];

	$edit_type = trim(strip_tags($_POST['edit_type']));

	if($edit_type == 'description') {
		$bs_description = trim(strip_tags($_POST['bs_description']));
		$bs_experience = trim(strip_tags($_POST['bs_experience']));

		$edit_bs = $connexion->prepare('UPDATE nap_users SET
			qui = :qui,
			experience = :experience
			WHERE id = :id');
		$edit_bs->execute(array(
			'qui' => $bs_description,
			'experience' => $bs_experience,
			'id' => $babysitterId
		));
		echo json_encode('ok');
	}elseif($edit_type == 'babysittings'){
		$age_debut = trim(strip_tags($_POST['age_debut']));
		$age_fin = trim(strip_tags($_POST['age_fin']));
		$new_born = trim(strip_tags($_POST['new_born']));
		$prix_bs = trim(strip_tags($_POST['prix_bs']));

		$prix = preg_split("/[,.]+/", $prix_bs);
		$prix_euro = $prix[0];
		$prix_cent = '00';
		if(isset($prix[1])){
			$prix_cent = $prix[1];
		}

		$edit_bs = $connexion->prepare('UPDATE nap_users SET
			age_debut = :age_debut,
			age_fin = :age_fin,
			new_born = :new_born,
			prix_euro = :prix_euro,
			prix_cent = :prix_cent
			WHERE id = :id');
		$edit_bs->execute(array(
			'age_debut' => $age_debut,
			'age_fin' => $age_fin,
			'new_born' => $new_born,
			'prix_euro' => $prix_euro,
			'prix_cent' => $prix_cent,
			'id' => $babysitterId
		));
		echo json_encode('ok');
	}

	// // Vérifications
	// if(empty($parent_password1)) {
	// 	$parent_password = $_SESSION['password'];
	// }else{
	// 	if($parent_password1 != $parent_password2) {
	// 		$results['password'][]='Les mots de passes ne sont pas identiques';
	// 	}else{
	// 		$parent_password = hash("sha256", $parent_password1);
	// 	}
	// }

	// if(empty($parent_email)){
	// 	$results['email'][]='Le champ email est vide';
	// }
	// elseif(!filter_var($parent_email, FILTER_VALIDATE_EMAIL)){
	//     $results['email'][]='Email invalide';
	// }

	// if(count($results) > 0) {
	// 	echo json_encode($results);
	// } else {
	// 	$edit_parent = $connexion->prepare('UPDATE nap_users SET
	// 		firstname = :firstname,
	// 		name = :name,
	// 		email = :email,
	// 		password = :password,
	// 		phone = :phone,
	// 		adress = :adress
	// 		WHERE id = :id');
	// 	$edit_parent->execute(array(
	// 		'firstname' => $parent_firstname,
	// 		'name' => $parent_name,
	// 		'email' => $parent_email,
	// 		'password' => $parent_password,
	// 		'phone' => $parent_phone,
	// 		'adress' => $parent_adress,
	// 		'id' => $parentId
	// 	));


	// 	echo json_encode('ok');
	// }










?>