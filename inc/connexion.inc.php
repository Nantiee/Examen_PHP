<?php
// Connexion serveur
	// error_reporting(E_WARNING | E_ERROR);

	// $PARAM_hote='mysql51-84.perso'; // le chemin vers le serveur
	// $PARAM_nom_bd='nantieebdd'; // le nom de votre base de données
	// $PARAM_utilisateur='nantieebdd'; // nom d'utilisateur pour se connecter
	// $PARAM_mot_passe='mdp'; // mot de passe de l'utilisateur pour se connecter

	// try {
	// 	$connexion = new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
	// }

	// catch(Exception $e) {
	// 	echo 'Une erreur est survenue !';
	// 	die();
	// }


// Connexion locale
	// error_reporting(E_WARNING | E_ERROR);

	$PARAM_hote='localhost'; // le chemin vers le serveur
	$PARAM_nom_bd='nappy'; // le nom de votre base de données
	$PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
	$PARAM_mot_passe='root'; // mot de passe de l'utilisateur pour se connecter

	try {
		$connexion = new PDO('mysql:host=localhost;dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
	}

	catch(Exception $e) {
		echo 'Une erreur est survenue !';
		die();
	}


?>