<?php
	session_start();
	if($_SESSION['logged_in']=='ok'){
		header('Location: index.php');
	}
?>
<html>
<?php include('inc/head.php'); ?>
<body id="landing">
	<div class="col-12">
		<a href="#" class="connexionButton">Me connecter</a>
		<div class="title col-12">
			<a href="inscription.php" class="6">
				<h1>Nappy</h1>
				<h2>Babysitters de confiance</h2>
			</a>
		</div>
		<div class="col-6 parent">
			<h3>Parent ?</h3>
			<p>
				Vous ne voulez pas confier votre enfant à n'importe qui ?
				<br>
				Vous voulez la perle rare qui lui correspondra parfaitement ?
				<br>
				Vous voulez trouver la babysitter qu'il redemandera !
			</p>
			<a href="#">Trouver mon babysitter !</a>
		</div>
		<div class="col-6 babysitter">
			<h3>Babysitter ?</h3>
			<p>
				Vous souhaitez vous occuper d'enfants ?
				<br>
				Être en contact avec une famille qui vous fera confiance et dont vous pourrez prendre soin ?
				<br>
				Vous voulez être celui qu'on rappelera !
			</p>
			<a href="#">Trouver ma famille !</a>
		</div>
	</div>


	<div id="inscription" class="col-12">
		<form method="post">
			<fieldset>
				<legend>Inscription</legend>
				<div>
					<input type="text" id="register_firstname" placeholder="Prénom">
					<p class="erreurs" data-erreurs='firstname'></p>
				</div>

				<div>
					<input type="text" id="register_name" placeholder="Nom">
					<p class="erreurs" data-erreurs='name'>name</p>
				</div>
				<div>
					<input type="email" id="register_email" placeholder="Email">
					<p class="erreurs" data-erreurs='email'>email</p>
				</div>

				<div>
					<input type="password" id="register_password" placeholder="Mot de passe">
					<p class="erreurs" data-erreurs='password'></p>
				</div>

				<div class="select">
					<div class="radio col-6">
						<input name="register_account_type" class="register_account_type" type="radio" id="babysitter" value="1">
						<label for="babysitter">Babysitter</label>
					</div>
					<div class="radio col-6">
						<input name="register_account_type" class="register_account_type" type="radio" id="parent" value="2">
						<label for="parent">Parent</label>
					</div>
					<p class="erreurs" data-erreurs='account_type'></p>
				</div>
				<div class="select gender radius">
					<div class="radio col-6">
						<input name="register_user_type" class="register_user_type" type="radio" id="femme" value="1">
						<label for="femme">Femme</label>
					</div>
					<div class="radio col-6">
						<input name="register_user_type" class="register_user_type" type="radio" id="homme" value="2">
						<label for="homme">Homme</label>
					</div>
					<p class="erreurs" data-erreurs='user_type'></p>
				</div>
					<input type="submit" value="Je m'incris !">
					<a href="#">Déjà inscrit ?</a>
			</fieldset>
		</form>
	</div>

	<div id="connexion" class="col-12">
		<fieldset>
			<form method="post">
				<legend>Connexion</legend>
				<div>
					<input type="email" id="login_email" placeholder="Email"/>
					<p class="erreurs" data-erreurs='email'></p>
				</div>
				<div class="radius">
					<input type="password" id="login_password" placeholder="Mot de passe"/>
					<p class="erreurs" data-erreurs='password'></p>
				</div>

				<input type="submit" value="connexion"/>
				<a href="#">Pas encore inscrit ?</a>
			</fieldset>
		</form>
	</div>



	<?php include('inc/script.php'); ?>


</body>
</html>












