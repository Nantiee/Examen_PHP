<?php
	session_start();
	include('inc/connexion.inc.php');

	$pageId = 7;
	if(!isset($_SESSION['logged_in'])){
		header('location: inscription.php');
	}

	extract($_POST);
	$results = array();

	$userId = $_SESSION['id'];

	$search_infos = $connexion->prepare('SELECT * FROM nap_users WHERE id = ?');
	$search_infos->execute(array($userId));
	$reponseInfos = $search_infos->fetch();

	$birth_split = explode('-', $reponseInfos['birth']);
	$year = $birth_split[0];
	$month = $birth_split[1];
	$day = $birth_split[2];
	$birth = $day.'-'.$month.'-'.$year;


?>
<!DOCTYPE html>
<html>
<?php include('inc/head.php'); ?>
<body>
	<?php include('inc/header.php'); ?>

	<div class="col-9 edit-profil" id="content">
		<?php
			if($_SESSION['account_type'] == '1' ){
		?>
		<a href="profil.php?id=<?=$_SESSION['id']; ?>" class="link-profil">Voir mon profil <i class="fa fa-fw">&#xf06e;</i></a>
		<div class="col-6">
			<h2><i class="fa">&#xf007;</i>Mes infos</h2>
			<div class="col-12 edit-blocs">
				<form id="edit-profil">
					<fieldset>
						<div class="name-photo">
							<div class="infos-2 name">
								<label for="edit_firstname">Prénom</label>
								<input type="text" id="edit_firstname" value="<?=$reponseInfos['firstname']; ?>">
							</div>
							<div class="infos-2 photo">
								<label for="edit_name">Photo</label>
								<div class="ratio">
									<div class="photo_preview" style="background-image: url('img/profils/<?php echo $reponseInfos['photo'];?>')"></div>
								</div>
								<input type="file" accept="image/jpeg" name="new_photo" id="edit_photo" >
							</div>
							<div class="infos-2 name">
								<label for="edit_name">Nom</label>
								<input type="text" id="edit_name" value="<?=$reponseInfos['name']; ?>">
							</div>
							<div class="infos-2 age">
								<label for="edit_birth">Date de naissance</label>
								<input type="text" id="edit_birth" placeholder="JJ-MM-AAAA" value="<?=$birth; ?>">
							</div>
						</div>
						<div class="infos-1">
							<label for="edit_password">Mot de passe</label>
							<input type="password" id="edit_password1" placeholder="Votre nouveau mot de passe">
							<input type="password" id="edit_password2" placeholder="Retapez votre nouveau mot de passe">
							<p class="erreurs" data-erreurs='password'>password</p>
						</div>
						<div class="infos-1">
							<label for="edit_email">Email</label>
							<input type="text" id="edit_email" value="<?=$reponseInfos['email']; ?>">
							<p class="erreurs" data-erreurs='email'>email</p>
						</div>
						<div class="infos-1">
							<label for="edit_phone">Téléphone</label>
							<input type="text" id="edit_phone" value="<?=$reponseInfos['phone']; ?>">

						</div>
						<div class="infos-1">
							<label for="edit_adress">Adresse</label>
							<textarea name="edit_adress" id="edit_adress" cols="30" rows="10"><?=$reponseInfos['adress']; ?></textarea>
						</div>
						<img class="loader" src="img/loader.gif" alt="loader" style="display: none;">
						<input type="submit" value="Mettre à jour mes infos"/>
					</fieldset>
				</form>
			</div>
		</div>
		<div class="col-6">
			<h2><i class="fa">&#xf091;</i>Qui suis-je ?</h2>
			<div class="col-12 edit-blocs">
				<form class="col-12 bs_description">
					<fieldset class="col-12">
						<div class="infos-1">
							<label for="edit_description">Qui êtes-vous, que faîtes vous ?</label>
							<textarea name="edit_description" id="bs_description" placeholder="Décrivez-vous le mieux possible pour être contacté !"><?=$reponseInfos['qui']; ?></textarea>
						</div>
						<div class="infos-1">
							<label for="edit_experience">Avez-vous de l'expérience ?</label>
							<textarea name="edit_experience" id="bs_experience" placeholder="Vous avez de l'expérience ? Félicitations, mettez la en avant !"><?=$reponseInfos['experience']; ?></textarea>
						</div>
						<img class="loader" src="img/loader.gif" alt="loader" style="display: none;">
						<input type="submit" value="Mettre à jour ma description"/>
					</fieldset>
				</form>
			</div>

			<h2><i class="fa">&#xf09b;</i>Mes babysittings</h2>
			<div class="col-12 edit-blocs">
				<form class="col-12 bs_babysittings">
					<fieldset class="col-12">
						<div class="infos-1">
							<p class="label_age_enfants">Je souhaite garder des enfants de</p>
							<div class="age_enfants">
								<label for="age_debut"></label>
								<input type="text" id="age_debut" value="<?=$reponseInfos['age_debut']; ?>">
							</div>
							<span>an(s)</span>
							<span class="age_enfants">à</span>
							<div class="age_enfants">
								<label for="age_fin"></label>
								<input type="text" id="age_fin" value="<?=$reponseInfos['age_fin']; ?>">
							</div>
							<span>ans</span>
						</div>
						<div class="infos-1 new_born">
							<input type="checkbox" name="new_born" id="new_born" <?php if($reponseInfos['new_born'] == '2'){echo 'checked';} ?>>
							<label for="new_born">Je peux garder des enfants de moins de 1 an.</label>
						</div>
						<div class="infos-1">
							<p class="label_prix_bs">À partir de</p>
							<div class="age_enfants">
								<label for="prix_bs"></label>
								<input type="text" id="prix_bs" value="<?php echo $reponseInfos['prix_euro']; if (!($reponseInfos['prix_cent'] == 0)) {
									echo ','.$reponseInfos['prix_cent'];
								}  ?>">
							</div>
							<span class="prix_bs">€ de l'heure</span>
						</div>
						<img class="loader" src="img/loader.gif" alt="loader" style="display: none;">
						<input type="submit" value="Mettre à jour ma description"/>
					</fieldset>
				</form>
			</div>
		</div>
		<?php }elseif($_SESSION['account_type'] == '2' ){ ?>
		<a href="profil.php?id=<?=$_SESSION['id']; ?>" class="link-profil">Voir mon profil <i class="fa fa-fw">&#xf06e;</i></a>
		<div class="col-6">
			<h2><i class="fa">&#xf007;</i>Mes infos</h2>
			<div class="col-12 edit-blocs">
				<form id="edit-profil">
					<fieldset>
						<div class="name-photo">
							<div class="infos-2 name">
								<label for="edit_firstname">Prénom</label>
								<input type="text" id="edit_firstname" value="<?=$reponseInfos['firstname']; ?>">
							</div>
							<div class="infos-2 photo">
								<label for="edit_name">Photo</label>
								<div class="ratio">
									<div class="photo_preview" style="background-image: url('img/profils/<?php echo $reponseInfos['photo'];;?>')"></div>
								</div>
								<input type="file" accept="image/jpeg" name="new_photo" id="edit_photo" >
							</div>
							<div class="infos-2 name">
								<label for="edit_name">Nom</label>
								<input type="text" id="edit_name" value="<?=$reponseInfos['name']; ?>">
							</div>
						</div>
						<div class="infos-1">
							<label for="edit_password">Mot de passe</label>
							<input type="password" id="edit_password1" placeholder="Votre nouveau mot de passe">
							<input type="password" id="edit_password2" placeholder="Retapez votre nouveau mot de passe">
							<p class="erreurs" data-erreurs='password'>password</p>
						</div>
						<div class="infos-1">
							<label for="edit_email">Email</label>
							<input type="text" id="edit_email" value="<?=$reponseInfos['email']; ?>">
							<p class="erreurs" data-erreurs='email'>email</p>
						</div>
						<div class="infos-1">
							<label for="edit_phone">Téléphone</label>
							<input type="text" id="edit_phone" value="<?=$reponseInfos['phone']; ?>">

						</div>
						<div class="infos-1">
							<label for="edit_adress">Adresse</label>
							<textarea name="edit_adress" id="edit_adress" cols="30" rows="10"><?=$reponseInfos['adress']; ?></textarea>
						</div>
						<img class="loader" src="img/loader.gif" alt="loader" style="display: none;">
						<input type="submit" value="Mettre à jour mes infos"/>
					</fieldset>
				</form>
			</div>

			<h2><i class="fa">&#xf15c;</i>À savoir</h2>
			<div class="col-12 edit-blocs">
				<form id="aSavoir">
					<fieldset>
						<div>
							<label>N° de téléphone des parents</label>
							<div class="infos-2">
								<input type="text" id="parent1" placeholder="Prénom" value="<?=$_SESSION['firstname']; ?>">
								<!-- <input type="text" id="phoneparent1" placeholder="N° de téléphone" value="<?=$_SESSION['phone']; ?>"> -->
								<input type="text" id="phoneparent1" placeholder="N° de téléphone" value="<?=$reponseInfos['phoneparent1']; ?>">
							</div>
							<div class="infos-2">
								<input type="text" id="parent2" placeholder="Prénom" value="<?=$reponseInfos['parent2']; ?>">
								<input type="text" id="phoneparent2" placeholder="N° de téléphone" value="<?=$reponseInfos['phoneparent2']; ?>">
							</div>
						</div>
						<div>
							<label for="">À contacter en cas d'urgence</label>
							<div class="infos-2">
								<input type="text" id="urgence1" placeholder="Personne à contacter" value="<?=$reponseInfos['urgence1']; ?>">
								<input type="text" id="urgencephone1" placeholder="N° de téléphone" value="<?=$reponseInfos['urgencephone1']; ?>">
							</div>
							<div class="infos-2">
								<input type="text" id="urgence2" placeholder="Personne à contacter" value="<?=$reponseInfos['urgence2']; ?>">
								<input type="text" id="urgencephone2" placeholder="N° de téléphone" value="<?=$reponseInfos['urgencephone2']; ?>">
							</div>
						</div>
						<div class='medecin'>
							<label for="">Médecin traitant</label>
							<div class="infos-2">
								<input type="text" id="docteurname" placeholder="Nom du médecin" value="<?=$reponseInfos['docteurname']; ?>">
							</div>
							<div class="infos-2">
								<input type="text" id="docteurphone" placeholder="N° de téléphone" value="<?=$reponseInfos['docteurphone']; ?>">
							</div>
							<div class="infos-1">
								<textarea id="docteuradress" placeholder="Adresse du médecin" value="<?=$reponseInfos['docteuradress']; ?>"></textarea>
							</div>
						</div>
						<div>
							<label for="">Important</label>
							<div class="infos-1">
								<textarea id="important" placeholder="Indiquez ici tout ce qu'il y a d'important à savoir sur vos enfants : allergies, habitudes importantes..." ><?=$reponseInfos['important']; ?></textarea>
							</div>
						</div>
						<img class="loader" src="img/loader.gif" alt="loader" style="display: none;">
						<input type="submit" value="Mettre à jour"/>
					</fieldset>
				</form>
			</div>
		</div>
		<div class="col-6">
			<h2><i class="fa">&#xf09b;</i>Mes enfants</h2>
			<div class="col-12 edit-blocs">
				<a href="#" id="add-child"><i class="fa fa-fw">&#xf055;</i>Ajouter un enfant</a>
				<div class="child" style="display:none;">
					<form class="new-child col-12">
						<fieldset class="col-12">
							<div>
								<div class="child_name infos-2">
									<label for="child_name" name="child_name">Prénom</label>
									<input class="col-4" type="text" id="child_name" placeholder="...">
								</div>
								<div class="child_birth infos-2">
									<label for="child_birth" name="child_birth">Date de naissance</label>
									<div id="child_birth" class="datefield">
									    <input id="number1" type="text" class="number day" maxlength="2" size="2" placeholder="JJ">
									    <input id="number2" type="text" class="number month" maxlength="2" size="2" placeholder="MM">
									    <input id="number3" type="text" class="number year" maxlength="4" size="4" placeholder="AAAA">
									</div>
								</div>
							</div>
							<div class="infos-1">
								<label for="child_description" name="child_description">Que souhaitez-vous dire à propos de votre enfant ?</label>
								<textarea name="" id="child_description" placeholder="Décrivez votre enfant, pour trouver le babysitter qui lui conviendra." cols="30" rows="10"></textarea>
							</div>
							<img class="loader" src="img/loader.gif" alt="loader" style="display: none;">
							<input type="submit" value="Ajouter un enfant">
						</fieldset>
					</form>
				</div>
				<?php
					$search_child = $connexion->query('SELECT * FROM nap_children WHERE parentId ='.$userId.' ORDER BY id DESC');
					while($reponseChild = $search_child->fetch()) {
						$birth = explode('-', $reponseChild['birth']);
						$birthYear = $birth[0];
						$birthMonth = $birth[1];
						$birthDay = $birth[2];
				?>
					<div class="child" data-child-id="<?=$reponseChild['id'] ?>">
						<form class="edit-child col-12" method="post">
							<fieldset class="col-12">
								<div>
									<div class="child_name infos-2">
										<label for="child_name" name="child_name">Prénom</label>
										<input class="col-4" type="text" id="child_name" placeholder="Prénom" value="<?=$reponseChild['firstname']; ?>">
										<p class="erreurs" data-erreurs='name'>Name</p>
									</div>
									<div class="child_birth infos-2">
										<label for="child_birth" name="child_birth">Date de naissance</label>
										<div id="child_birth" class="datefield">
										    <input id="number1" type="text" class="number day" maxlength="2" size="2" placeholder="JJ" value="<?=$birthDay; ?>">
										    <input id="number2" type="text" class="number month" maxlength="2" size="2" placeholder="MM" value="<?=$birthMonth; ?>">
										    <input id="number3" type="text" class="number year" maxlength="4" size="4" placeholder="AAAA" value="<?=$birthYear; ?>">
										</div>
										<p class="erreurs" data-erreurs='birth'>Birth</p>
									</div>
								</div>
								<div class="infos-1">
									<label for="child_description" name="child_description">Que souhaitez-vous dire à propos de votre enfant ?</label>
									<textarea name="" id="child_description" placeholder="Décrivez votre enfant, pour trouver le babysitter qui lui conviendra."><?php echo $reponseChild['description']; ?></textarea>
								</div>
								<img class="loader" src="img/loader.gif" alt="loader" style="display: none;">
								<input type="submit" value="Mettre à jour <?=$reponseChild['firstname']; ?>">
							</fieldset>
						</form>
					</div>
				<?php
					}
				?>

			</div>
		</div>
		<?php } ?>
	</div>
<?php include('inc/script.php'); ?>
</body>

</html>












