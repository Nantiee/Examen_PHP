<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();

	$parentId = $_SESSION['id'];


	$parent_firstname = trim(strip_tags($_POST['parent_firstname']));
	$parent_name = trim(strip_tags($_POST['parent_name']));
	$parent_birth = trim(strip_tags($_POST['parent_birth']));
	$parent_password1 = trim(strip_tags($_POST['parent_password1']));
	$parent_password2 = trim(strip_tags($_POST['parent_password2']));
	$parent_email = trim(strip_tags($_POST['parent_email']));
	$parent_phone = trim(strip_tags($_POST['parent_phone']));
	$parent_adress = trim(strip_tags($_POST['parent_adress']));

	$birth_split = explode('-', $parent_birth);
	$day = $birth_split[0];
	$month = $birth_split[1];
	$year = $birth_split[2];
	$birth = $year.'-'.$month.'-'.$day;

	// Vérifications
	if(empty($parent_password1)) {
		$parent_password = $_SESSION['password'];
	}else{
		if($parent_password1 != $parent_password2) {
			$results['password'][]='Les mots de passes ne sont pas identiques';
		}else{
			$parent_password = hash("sha256", $parent_password1);
		}
	}

	if(empty($parent_email)){
		$results['email'][]='Le champ email est vide';
	}
	elseif(!filter_var($parent_email, FILTER_VALIDATE_EMAIL)){
	    $results['email'][]='Email invalide';
	}

	if(count($results) > 0) {
		echo json_encode($results);
	} else {
		$edit_parent = $connexion->prepare('UPDATE nap_users SET
			firstname = :firstname,
			name = :name,
			birth = :birth,
			email = :email,
			password = :password,
			phone = :phone,
			adress = :adress
			WHERE id = :id');
		$edit_parent->execute(array(
			'firstname' => $parent_firstname,
			'name' => $parent_name,
			'birth' => $birth,
			'email' => $parent_email,
			'password' => $parent_password,
			'phone' => $parent_phone,
			'adress' => $parent_adress,
			'id' => $parentId
		));


		echo json_encode('ok');
	}










?>