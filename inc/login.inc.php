<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();

	$login_email = trim(strip_tags($_POST['login_email']));
	$login_password = trim(strip_tags($_POST['login_password']));

	$login_password = hash("sha256", $login_password);

	$search_user = $connexion->prepare("SELECT * FROM nap_users WHERE email = ?");
	$search_user->execute(array($login_email));
	$reponse = $search_user->fetch();

	if($reponse['email'] == false) {
		$results['erreurs']['email'][]='Cet adresse email n\'existe pas';
		echo json_encode($results);
	}else{
		if($reponse['password'] == $login_password){
			$last_connected = date("U");

			$search_user = $connexion->prepare('SELECT * FROM nap_users WHERE email = ?');
			$search_user->execute(array($login_email));
			$reponse = $search_user->fetch();

			$edit_date = $connexion->prepare('UPDATE nap_users SET last_connected = :last_connected WHERE id = :user_id');
			$edit_date->execute(array('last_connected'=>$last_connected, 'user_id'=>$reponse['id']));

			$_SESSION['id']=$reponse['id'];
			$_SESSION['email']=$login_email;
			$_SESSION['password']=$login_password;
			$_SESSION['firstname']=$reponse['firstname'];
			$_SESSION['password']=$reponse['password'];
			$_SESSION['name']=$reponse['name'];
			$_SESSION['birth']=$reponse['birth'];
			$_SESSION['phone']=$reponse['phone'];
			$_SESSION['account_type']=$reponse['account_type'];
			$_SESSION['last_connected']=$last_connected;
			$_SESSION['logged_in']='ok';
			$_SESSION['photo']=$reponse['photo'];
			$_SESSION['adress']=$reponse['adress'];

			if(empty($_SESSION['photo'])){
				$_SESSION['photo'] = 'default.jpg';
			}

			echo json_encode('ok');
		}else{
			$results['erreurs']['password'][]='Mot de passe incorrect';
			echo json_encode($results);
		}
	}


?>