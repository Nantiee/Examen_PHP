<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$register_firstname = trim(strip_tags($_POST['register_firstname']));
	$register_name = trim(strip_tags($_POST['register_name']));
	$register_email = trim(strip_tags($_POST['register_email']));
	$register_password = trim(strip_tags($_POST['register_password']));
	$register_account_type = trim(strip_tags($_POST['register_account_type']));
	$register_user_type = trim(strip_tags($_POST['register_user_type']));


	$results = array();

	// VERIF INSCRIPTION
	if(empty($register_firstname)){
		$results['firstname'][]='Le champ prénom est vide';
	} elseif((preg_match("/^[a-zA-Z]*$/", $register_firstname)) == 0){
	    $results['firstname'][]="Veuillez ne mettre que des lettres";
	}

	if(empty($register_name)){
		$results['name'][]='Le champ nom est vide';
	} elseif((preg_match("/^[a-zA-Z]*$/", $register_name)) == 0){
	    $results['name'][]="Veuillez ne mettre que des lettres";
	}

	if(empty($register_email)){
		$results['email'][]='Le champ email est vide';
	} elseif(!filter_var($register_email, FILTER_VALIDATE_EMAIL)){
	    $results['email'][]='Email invalide';
	}

	if(empty($register_password)){
		$results['password'][]='Le champ mot de passe est vide';
	}

	if($register_account_type < 1 || $register_account_type > 2 || empty($register_account_type)){
		$results['account_type'][]='Êtes vous parent ou babysitter ?';
	}

	if($register_account_type == 1 && $register_user_type == 3){
		$results['user_type'][]='Êtes vous un homme ou une femme ?';
	}

	if(count($results) > 0) {
		echo json_encode($results);
	}else{
		// FONCION AJOUT
		$search_user = $connexion->prepare('SELECT email FROM nap_users WHERE email = ?');
		$search_user->execute(array($register_email));
		$reponse = $search_user->fetch();

		if($reponse['email'] == $register_email){
			$results['erreurs']['email'][]='Cet email existe déjà';
			echo json_encode($results);
		}
		else{
			$register_password = hash("sha256", $register_password);
			$last_connected = date("U");
			$add_user = $connexion->prepare("INSERT INTO
				nap_users (firstname, name, email, password, account_type, user_type, last_connected)
				VALUES (:firstname, :name, :email, :password, :account_type, :user_type, :last_connected)");
			$add_user->execute(array(
				'firstname'=>$register_firstname,
				'name'=>$register_name,
				'email'=>$register_email,
				'password'=>$register_password,
				'account_type'=>$register_account_type,
				'user_type'=>$register_user_type,
				'last_connected'=>$last_connected
			));

			$_SESSION['firstname']=$register_firstname;
			$_SESSION['name']=$register_name;
			$_SESSION['email']=$register_email;
			$_SESSION['password']=$register_password;
			$_SESSION['account_type']=$register_account_type;
			$_SESSION['user_type']=$register_user_type;
			$_SESSION['last_connected']=$last_connected;
			$_SESSION['photo']='default';
			$_SESSION['logged_in']='ok';

			$search_user = $connexion->prepare('SELECT id FROM nap_users WHERE email = ?');
			$search_user->execute(array($register_email));
			$reponse = $search_user->fetch();

			$_SESSION['id']=$reponse['id'];


			echo json_encode('ok');

		}
		// envoi_mail();
	}




	// function envoi_mail(){
	// 	$mail = $register_email;

	// 	require_once 'class.phpmailer.php';
	// 	$email = new PHPMailer;
	// 	require_once 'mailconfig.inc.php';

	// 	$email->From = 'info@nantiee.be';
	// 	$email->FromName = 'TFA';
	// 	$email->AddAddress('anne.jouan.info@gmail.com', 'Anne Jouan');
	// 	$email->AddReplyTo($mail, 'janine');

	// 	$email->Subject ="Bienvenue sur Nappy !";
	// 	$email->Body    = file_get_contents("email/signin_valid.html");
	// 	$email->Body  = preg_replace("%_pseudo_%", $register_name, $email->Body);

	// 	if(!$email->Send()) {

	//    		echo json_encode('Message could not be sent.');
	//    		exit;
	// 	}
	// }











?>