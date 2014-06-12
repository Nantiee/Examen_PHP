<?php
	session_start();
	include('inc/functions.inc.php');
	$pageId = 6;
	$account_type = $_SESSION['account_type'];
	$userId = $_SESSION['id'];
	if(!isset($_SESSION['logged_in'])){
		header('location: inscription.php');
	}

	// function month($value){
	// 	if($value=='01'){$month_text='Janvier';}
	// 	elseif($value=='02'){$month_text='Février';}
	// 	elseif($value=='03'){$month_text='Mars';}
	// 	elseif($value=='04'){$month_text='Avril';}
	// 	elseif($value=='05'){$month_text='Mai';}
	// 	elseif($value=='06'){$month_text='Juin';}
	// 	elseif($value=='07'){$month_text='Juillet';}
	// 	elseif($value=='08'){$month_text='Août';}
	// 	elseif($value=='09'){$month_text='Septembre';}
	// 	elseif($value=='10'){$month_text='Octobre';}
	// 	elseif($value=='11'){$month_text='Novembre';}
	// 	elseif($value=='12'){$month_text='Décembre';}
	// 	return $month_text;
	// }
?>
<!DOCTYPE html>
<html>
<?php include('inc/head.php'); ?>
<body>
	<?php include('inc/header.php'); ?>
	<p class="col-9 avertissement">L'acceptation d'une demande n'établit pas de contrat. Assurez-vous de contacter chaque personne pour obtenir les informations nécessaires, vous mettre d'accord sur le prix définitif, et obtenir une confirmation du babysitting.</p>
	<div class="col-9" id="content">
		<?php
			if($account_type == 1) {
		?>

		<h2>Demandes reçues</h2>
		<ul class="demande col-12">
				<?php
					function heure($value)
					{
						$heure = substr($value, 0, 2);
						$min = substr($value, 2);
						return $horaire = $heure.':'.$min;
					}
					$data = false;

					$search_demandes = $connexion->query("SELECT * FROM nap_demandes WHERE babysitterID = ".$userId." AND status = 3 ORDER BY id_demandes DESC");

					while ($demande = $search_demandes->fetch()) {
						$data = true;

						$demandeDate = explode('-', $demande['date_demande']);
						$demandeDateYear = $demandeDate[0];
						$demandeDateMonth = $demandeDate[1];
						$demandeDateDay = $demandeDate[2];

						$bsDate = explode('-', $demande['datebs']);
						$bsDateYear = $bsDate[0];
						$bsDateMonth = $bsDate[1];
						$bsDateDay = $bsDate[2];

						$parent_demande = $connexion->query("SELECT * FROM nap_users WHERE id = ".$demande['parentId']."  ");
						$parent = $parent_demande->fetch();
				?>

				<li data-demandeid="<?php echo $demande['id_demandes']; ?>">
					<div class="side">
						<img src="img/profils/<?php echo $parent['photo']; ?>" alt="Photo de <?php echo $parent['firstname']; ?>">
						<p><?php echo $parent['firstname']; ?></p>
						<span class="date"><?echo $demandeDateDay.' '.month($demandeDateMonth).' '.$demandeDateYear; ?></span>
					</div>
					<?php if(!(empty($demande['datebs']))) { ?>
					<ul>
						<li>
							<i class="fa">&#xf133;</i>
							<span><?echo $bsDateDay.' '.month($bsDateMonth).' '.$bsDateYear; ?></span>
						</li>
						<li>
							<i class="fa">&#xf017;</i>
							<span>
							<?php
								echo heure($demande['debut']).'-'.heure($demande['fin']);
							?></span>
						</li>
						<li>
							<i class="fa">&#xf041;</i>
							<span>
							<?php
								$split = explode(" ", $demande['adressbs']);
								$ville = $split[count($split)-1];
								echo $ville;
							?></span>
						</li>
						<li>
							<i class="fa">&#xf09b;</i>
							<span><?php echo $demande['children']; ?></span>
						</li>
						<li>
							<i class="fa">&#xf095;</i>
							<span><?php echo $demande['phone']; ?></span>
						</li>
					</ul>
					<?php } ?>
					<div class="message">
						<p>
						<?php echo $demande['message']; ?>
						</p>
							<a href="#" class="refuser">refuser</a>
					<a href="#" class="valider">Accepter</a>
				</div>
				<div class="demandeReponse">
					<form action="" class="col-12">
						<label for="message">Répondre à <?php echo $parent['firstname']; ?></label>
						<textarea name="message" placeholder="" id="message" cols="30" rows="7" required></textarea>
						<a href="#" class="annuler">annuler</a>
						<input type="submit" class="valider" value="Envoyer">
					</form>
				</div>
				</li>
				<?php }

					if($data == false){
				?>
				<li class="no-demande">Vous n'avez pas reçu de demande.</li>
				<?php } ?>
		</ul>
		<h2>Demandes acceptées</h2>
		<ul class="demande col-12">
				<?php

					$data = false;
					$demandes_refuse = $connexion->query("SELECT * FROM nap_demandes WHERE babysitterID = ".$userId." AND status = 2");
					while ($demande = $demandes_refuse->fetch()) {
						$data = true;
						$demandeDate = explode('-', $demande['date_demande']);
						$demandeDateYear = $demandeDate[0];
						$demandeDateMonth = $demandeDate[1];
						$demandeDateDay = $demandeDate[2];

						$bsDate = explode('-', $demande['datebs']);
						$bsDateYear = $bsDate[0];
						$bsDateMonth = $bsDate[1];
						$bsDateDay = $bsDate[2];

						$reponseDate = explode('-', $demande['date_reponse']);
						$reponseDateYear = $reponseDate[0];
						$reponseDateMonth = $reponseDate[1];
						$reponseDateDay = $reponseDate[2];

						$parent_demande = $connexion->query("SELECT * FROM nap_users WHERE id = ".$demande['parentId']."  ");
						$parent = $parent_demande->fetch();



				?>
				<li data-demandeid="<?php echo $demande['id_demandes']; ?>">
					<div class="side">
						<img src="img/profils/<?php echo $parent['photo']; ?>" alt="Photo de <?php echo $parent['firstname']; ?>">
						<p><?php echo $parent['firstname']; ?></p>
						<span class="date"><?echo $demandeDateDay.' '.month($demandeDateMonth).' '.$demandeDateYear; ?></span>
					</div>
					<?php if(!(empty($demande['datebs']))) { ?>
					<ul>
						<li>
							<i class="fa">&#xf133;</i>
							<span><?echo $bsDateDay.' '.month($bsDateMonth).' '.$bsDateYear; ?></span>
						</li>
						<li>
							<i class="fa">&#xf017;</i>
							<span>
							<?php
								echo heure($demande['debut']).'-'.heure($demande['fin']);
							?></span>
						</li>
						<li>
							<i class="fa">&#xf041;</i>
							<span>
							<?php
								echo $demande['adressbs'];
							?></span>
						</li>
						<li>
							<i class="fa">&#xf09b;</i>
							<span><?php echo $demande['children']; ?></span>
						</li>
						<li>
							<i class="fa">&#xf095;</i>
							<span><?php echo $demande['phone']; ?></span>
						</li>
					</ul>
					<?php } ?>
					<div class="message">
						<p>
							<?php echo $demande['message']; ?>
						</p>

					</div>
					<div class="reponse">
						<i>Vous avez répondu le <?echo $reponseDateDay.' '.month($reponseDateMonth).' '.$reponseDateYear; ?> :</i>
						<p>
							<?php echo $demande['reponse_babysitter']; ?>
						</p>
					<span href="" class="accepted">Accepté</span>
					</div>
				</li>
				<?php }

					if($data == false){
				?>
				<li class="no-demande">Vous n'avez pas accepté de demande.</li>
				<?php } ?>
			</ul>

			<h2>Demandes refusées</h2>
			<ul class="demande col-12">
				<?php
					$data = false;
					$demandes_refuse = $connexion->query("SELECT * FROM nap_demandes WHERE babysitterID = ".$userId." AND status = 1");
					while ($demande = $demandes_refuse->fetch()) {
						$data = true;
						$demandeDate = explode('-', $demande['date_demande']);
						$demandeDateYear = $demandeDate[0];
						$demandeDateMonth = $demandeDate[1];
						$demandeDateDay = $demandeDate[2];

						$bsDate = explode('-', $demande['datebs']);
						$bsDateYear = $bsDate[0];
						$bsDateMonth = $bsDate[1];
						$bsDateDay = $bsDate[2];

						$reponseDate = explode('-', $demande['date_reponse']);
						$reponseDateYear = $reponseDate[0];
						$reponseDateMonth = $reponseDate[1];
						$reponseDateDay = $reponseDate[2];

						$parent_demande = $connexion->query("SELECT * FROM nap_users WHERE id = ".$demande['parentId']."  ");
						$parent = $parent_demande->fetch();



				?>
				<li data-demandeid="<?php echo $demande['id_demandes']; ?>">
					<div class="side">
						<img src="img/profils/<?php echo $parent['photo']; ?>" alt="Photo de <?php echo $parent['firstname']; ?>">
						<p><?php echo $parent['firstname']; ?></p>
						<span class="date"><?echo $demandeDateDay.' '.month($demandeDateMonth).' '.$demandeDateYear; ?></span>
					</div>
					<?php if(!(empty($demande['datebs']))) { ?>
					<ul>
						<li>
							<i class="fa">&#xf133;</i>
							<span><?echo $bsDateDay.' '.month($bsDateMonth).' '.$bsDateYear; ?></span>
						</li>
						<li>
							<i class="fa">&#xf017;</i>
							<span>
							<?php
								echo heure($demande['debut']).'-'.heure($demande['fin']);
							?></span>
						</li>
						<li>
							<i class="fa">&#xf041;</i>
							<span>
							<?php
								echo $demande['adressbs'];
							?></span>
						</li>
						<li>
							<i class="fa">&#xf09b;</i>
							<span><?php echo $demande['children']; ?></span>
						</li>
						<li>
							<i class="fa">&#xf095;</i>
							<span><?php echo $demande['phone']; ?></span>
						</li>
					</ul>
					<?php } ?>
					<div class="message">
						<p>
							<?php echo $demande['message']; ?>
						</p>

					</div>
					<div class="reponse">
						<i>Vous avez répondu le <?echo $reponseDateDay.' '.month($reponseDateMonth).' '.$reponseDateYear; ?> :</i>
						<p>
							<?php echo $demande['reponse_babysitter']; ?>
						</p>
					<span class="refused">Refusé</span>
					</div>
				</li>
				<?php }

					if($data == false){
				?>
				<li class="no-demande">Vous n'avez pas refuser de demandes.</li>
				<?php } ?>
			</ul>
		<?php }elseif($account_type == 2) { ?>
			<h2>Demandes envoyées</h2>
			<ul class="demande col-12">
				<?php
					function heure($value)
					{
						$heure = substr($value, 0, 2);
						$min = substr($value, 2);
						return $horaire = $heure.':'.$min;
					}
					$data = false;

					$search_demandes = $connexion->query("SELECT * FROM nap_demandes WHERE parentID = ".$userId." AND status = 3 ");
					while ($demande = $search_demandes->fetch()) {
						$data = true;


						$demandeDate = explode('-', $demande['date_demande']);
						$demandeDateYear = $demandeDate[0];
						$demandeDateMonth = $demandeDate[1];
						$demandeDateDay = $demandeDate[2];

						$bsDate = explode('-', $demande['datebs']);
						$bsDateYear = $bsDate[0];
						$bsDateMonth = $bsDate[1];
						$bsDateDay = $bsDate[2];

						$babysitter_demande = $connexion->query("SELECT * FROM nap_users WHERE id = ".$demande['babysitterId']."  ");
						$babysitter = $babysitter_demande->fetch();

				?>
				<li data-demande="<?php echo $demande['id_demandes']; ?>">
					<div class="side">
						<img src="img/profils/<?php echo $babysitter['photo']; ?>" alt="Photo de <?php echo $demande['firstname']; ?>">
						<p><?php echo $babysitter['firstname']; ?></p>
						<span class="date"><?echo $demandeDateDay.' '.month($demandeDateMonth).' '.$demandeDateYear; ?></span>
					</div>
					<?php if(!(empty($demande['datebs']))) { ?>
					<ul>
						<li>
							<i class="fa">&#xf133;</i>
							<span><?php echo $demande['datebs']; ?></span>
						</li>
						<li>
							<i class="fa">&#xf017;</i>
							<span>
							<?php
								echo heure($demande['debut']).'-'.heure($demande['fin']);
							?></span>
						</li>
						<li>
							<i class="fa">&#xf041;</i>
							<span>
							<?php
								echo $demande['adressbs'];
							?></span>
						</li>
						<li>
							<i class="fa">&#xf09b;</i>
							<span><?php echo $demande['children']; ?></span>
						</li>
						<li>
							<i class="fa">&#xf095;</i>
							<span><?php echo $demande['phone']; ?></span>
						</li>
					</ul>
					<?php } ?>
					<div class="message">
						<p>
						<?php echo $demande['message']; ?>
						</p>
						<a href="#" data-no-instant class="refuser delete-demande">Annuler</a>
					</div>
				</li>
				<?php }

					if($data == false){
				?>
				<li class="no-demande">Vous n'avez pas de demandes en attente.</li>
				<?php } ?>
			</ul>


			<h2>Demandes acceptées</h2>
			<ul class="demande col-12">
				<?php
					$data = false;
					$demandes_refuse = $connexion->query("SELECT * FROM nap_demandes WHERE parentID = ".$userId." AND status = 2");
					while ($demande = $demandes_refuse->fetch()) {
						$data = true;
						$demandeDate = explode('-', $demande['date_demande']);
						$demandeDateYear = $demandeDate[0];
						$demandeDateMonth = $demandeDate[1];
						$demandeDateDay = $demandeDate[2];

						$bsDate = explode('-', $demande['datebs']);
						$bsDateYear = $bsDate[0];
						$bsDateMonth = $bsDate[1];
						$bsDateDay = $bsDate[2];

						$reponseDate = explode('-', $demande['date_reponse']);
						$reponseDateYear = $reponseDate[0];
						$reponseDateMonth = $reponseDate[1];
						$reponseDateDay = $reponseDate[2];

						$babysitter_demande = $connexion->query("SELECT * FROM nap_users WHERE id = ".$demande['babysitterId']."  ");
						$babysitter = $babysitter_demande->fetch();



				?>
				<li data-demandeid="<?php echo $demande['id_demandes']; ?>">
					<div class="side">
						<img src="img/profils/<?php echo $babysitter['photo']; ?>" alt="Photo de <?php echo $demande['firstname']; ?>">
						<p><?php echo $babysitter['firstname']; ?></p>
						<span class="date"><?echo $demandeDateDay.' '.month($demandeDateMonth).' '.$demandeDateYear; ?></span>
					</div>
					<?php if(!(empty($demande['datebs']))) { ?>
					<ul>
						<li>
							<i class="fa">&#xf133;</i>
							<span><?echo $bsDateDay.' '.month($bsDateMonth).' '.$bsDateYear; ?></span>
						</li>
						<li>
							<i class="fa">&#xf017;</i>
							<span>
							<?php
								echo heure($demande['debut']).'-'.heure($demande['fin']);
							?></span>
						</li>
						<li>
							<i class="fa">&#xf041;</i>
							<span>
							<?php
								echo $demande['adressbs'];
							?></span>
						</li>
						<li>
							<i class="fa">&#xf09b;</i>
							<span><?php echo $demande['children']; ?></span>
						</li>
						<li>
							<i class="fa">&#xf095;</i>
							<span><?php echo $demande['phone']; ?></span>
						</li>
					</ul>
					<?php } ?>
					<div class="message">
						<p>
							<?php echo $demande['message']; ?>
						</p>

					</div>
					<div class="reponse">
						<i>Matt a répondu le <?echo $reponseDateDay.' '.month($reponseDateMonth).' '.$reponseDateYear; ?> :</i>
						<p>
							<?php echo $demande['reponse_babysitter']; ?>
						</p>
					<span href="" class="accepted">Accepté</span>
					</div>
				</li>
				<?php }

					if($data == false){
				?>
				<li class="no-demande">Vous n'avez pas de demandes acceptées.</li>
				<?php } ?>
			</ul>

			<h2>Demandes refusées</h2>
			<ul class="demande col-12">
				<?php
					$data = false;
					$demandes_refuse = $connexion->query("SELECT * FROM nap_demandes WHERE parentID = ".$userId." AND status = 1");
					while ($demande = $demandes_refuse->fetch()) {
						$data = true;
						$demandeDate = explode('-', $demande['date_demande']);
						$demandeDateYear = $demandeDate[0];
						$demandeDateMonth = $demandeDate[1];
						$demandeDateDay = $demandeDate[2];

						$bsDate = explode('-', $demande['datebs']);
						$bsDateYear = $bsDate[0];
						$bsDateMonth = $bsDate[1];
						$bsDateDay = $bsDate[2];

						$reponseDate = explode('-', $demande['date_reponse']);
						$reponseDateYear = $reponseDate[0];
						$reponseDateMonth = $reponseDate[1];
						$reponseDateDay = $reponseDate[2];

						$babysitter_demande = $connexion->query("SELECT * FROM nap_users WHERE id = ".$demande['babysitterId']."  ");
						$babysitter = $babysitter_demande->fetch();



				?>
				<li data-demandeid="<?php echo $demande['id_demandes']; ?>">
					<div class="side">
						<img src="img/profils/<?php echo $babysitter['photo']; ?>" alt="Photo de <?php echo $demande['firstname']; ?>">
						<p><?php echo $babysitter['firstname']; ?></p>
						<span class="date"><?echo $demandeDateDay.' '.month($demandeDateMonth).' '.$demandeDateYear; ?></span>
					</div>
					<?php if(!(empty($demande['datebs']))) { ?>
					<ul>
						<li>
							<i class="fa">&#xf133;</i>
							<span><?echo $bsDateDay.' '.month($bsDateMonth).' '.$bsDateYear; ?></span>
						</li>
						<li>
							<i class="fa">&#xf017;</i>
							<span>
							<?php
								echo heure($demande['debut']).'-'.heure($demande['fin']);
							?></span>
						</li>
						<li>
							<i class="fa">&#xf041;</i>
							<span>
							<?php
								echo $demande['adressbs'];
							?></span>
						</li>
						<li>
							<i class="fa">&#xf09b;</i>
							<span><?php echo $demande['children']; ?></span>
						</li>
						<li>
							<i class="fa">&#xf095;</i>
							<span><?php echo $demande['phone']; ?></span>
						</li>
					</ul>
					<?php } ?>
					<div class="message">
						<p>
							<?php echo $demande['message']; ?>
						</p>

					</div>
					<div class="reponse">
						<i>Matt a répondu le <?echo $reponseDateDay.' '.month($reponseDateMonth).' '.$reponseDateYear; ?> :</i>
						<p>
							<?php echo $demande['reponse_babysitter']; ?>
						</p>
					<span class="refused">Refusé</span>
					</div>
				</li>
				<?php }

					if($data == false){
				?>
				<li class="no-demande">Vous n'avez pas de demandes refusées.</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</div>
	<?php include('inc/script.php'); ?>
</body>


</html>












