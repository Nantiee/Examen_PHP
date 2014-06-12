<?php
	session_start();
	include('inc/connexion.inc.php');
	include('inc/functions.inc.php');
	$pageId = 9;
	if (isset($_GET['id'])) {
		$userId = $_GET['id'];
	}else{
		header('location: search.php');
	}




	// INFOS PARENTS
	$infos_user = $connexion->query('SELECT * FROM nap_users WHERE id = '.$userId);
	$reponse = $infos_user->fetch();
	$this_account_type = $reponse['account_type'];

	// print_r($reponse);
	$adresse = $reponse['adress'];

	// Split Adresse + Ville
	$split = explode(" ", $adresse);
	$ville = $split[count($split)-1];
	$adresse = str_replace($ville,'',$adresse);

	// INFOS ENFANTS
	$infos_child = $connexion->query('SELECT id FROM nap_children WHERE parentId = '.$userId);

	$nbChild = 0;
	while($reponseChild = $infos_child->fetch()) {
		$nbChild = $nbChild+1;
	}


	// print_r($reponseChild);

	echo $reponseChild['id'];


?>
<!DOCTYPE html>
<html>
<?php include('inc/head.php'); ?>
<body>
	<?php
		include('inc/header.php');
		if($this_account_type == '2' ){
	?>
		<div class="col-9 profil" id="content">
			<div class="profil-banner">
				<img src="img/profils/<?php echo $reponse['photo'];?>" alt="" class="profil-banner-image">
				<div class="banner-infos">
					<ul>
						<li class="left uppercase"><?=$reponse['firstname']; ?></li>
						<li class="right"><span class="uppercase"><?=$ville; ?></span><?=$adresse; ?></li>
						<li class="left"><?=$reponse['name']; ?></li>
						<li class="right"><?=$reponse['phone']; ?></li>
						<li class="left">
							<?php if($nbChild == 0){echo('Pas encore d\'enfant ajouté');}else{
								echo $nbChild; ?> enfant<?php if($nbChild > 1){echo 's';}
							} ?>
						</li>
						<li class="right"><?=$reponse['email']; ?></li>
					</ul>
				</div>
			</div>
			<div class="col-12 description">
				<div class="col-6 enfants">
					<h2><i class="fa">&#xf09b;</i>Mes enfants</h2>
					<ul>
						<?php
							$infos_child = $connexion->query('SELECT firstname, birth FROM nap_children WHERE parentId = '.$userId);
								// DATE DU JOUR
								$year = date('Y');
								$month = date('m');
								$day = date('d');
							while($reponseChild = $infos_child->fetch()) {
							///////// // CALCUL DE L'ÂGE
								$birth = explode('-', $reponseChild['birth']);
								$birthYear = $birth[0];
								$birthMonth = $birth[1];
								$birthDay = $birth[2];
								$age = $year-$birthYear;
								$diffMonth = $month-$birthMonth;
								if($diffMonth < 0) {
									$age = $age-1;
								}elseif ($diffMonth == 0) {
									$diffDay = $day-$birthDay;
									if ($diffDay < 0) {
										$age = $age-1;
									}
								}
						?>
								<li><span><?=$reponseChild['firstname']; ?></span> (<?=$age; ?> ans)</li>
						<?php }	?>
					</ul>
					<?php
						$infos_child = $connexion->query('SELECT firstname, description FROM nap_children WHERE parentId = '.$userId);
						while($reponseChild = $infos_child->fetch()) {
							$description = $reponseChild['description'];
							$description = explode(' ', $description, 2);
					?>
					<p><span><?=$reponseChild['firstname']; ?></span> <?=$description[1]; ?></p>
					<?php } ?>
				</div>
				<div class="col-6 savoir">
					<h2><i class="fa">&#xf15c;</i>À savoir</h2>
					<ul>
						<li>
							<h3>N° de téléphone des parents</h3>
							<span><?=$reponse['parent1']; ?> <br><?=$reponse['phoneparent1']; ?></span>
							<span><?=$reponse['parent2']; ?> <br><?=$reponse['phoneparent2']; ?></span>
						</li>
						<li>
							<h3>À contacter en cas d'urgence</h3>
							<span><?=$reponse['urgence1']; ?> <br><?=$reponse['urgencephone1']; ?></span>
							<span><?=$reponse['urgence2']; ?> <br><?=$reponse['urgencephone2']; ?></span>
						</li>
						<li>
							<h3>Médecin traitant</h3>
							<span><?=$reponse['docteurname']; ?></span>
							<span><?=$reponse['docteurphone']; ?></span>
							<p><?=$reponse['docteuradress']; ?></p>
						</li>
						<li>
							<h3>Important</h3>
							<p><?=$reponse['important']; ?></p>
						</li>
					</ul>
				</div>
			</div>
		</div>

	<?php
		}
		if($this_account_type == '1' ){
	?>

	<div class="col-9 profil" id="content">
		<div class="profil-banner">
			<img src="img/profils/<?php echo $reponse['photo'];?>" alt="Photo de <?=$reponse['firstname']; ?>" class="col- profil-banner-image">
			<div class="banner-infos">
				<ul>
					<li class="left uppercase"><span class="gender" style="background-image: url(img/<?php if($reponse['user_type'] == 1){echo('fe');} ?>male.svg);"></span><?=$reponse['firstname']; ?></li>
					<li class="right uppercase"><?=$ville; ?></li>
					<li class="left"><?=$reponse['name']; ?></li>
					<li class="right"><?=$reponse['phone']; ?></li>
					<li class="left"><?php if (age($reponse['birth']) != 2014) {
						echo age($reponse['birth']).' ans';
					}else{echo 'Âge non indiqué';}  ?> </li>
					<li class="right"><?=$reponse['email']; ?></li>
				</ul>
				<span class="favcom">
					<?php
						$n = 0;
						$i = 0;
						$fav = 0;
						$nbcomment = 0;
						$check_notes = $connexion->query('SELECT note, favoris, comment FROM nap_comments WHERE babysitterId = '.$userId);
						while ($infos = $check_notes->fetch()) {
							if ($infos['favoris'] == 1) {
								$fav = $fav + 1;
							}
							if ($infos['comment'] != '') {
								$nbcomment = $nbcomment + 1;
							}
							$i = $i +1;
							$n = $n + $infos['note'];
							$m = $n/$i;

						}
					?>


					<i class="fa like">
						<?php
							if (!(isset($m)) || ($m == '0')) {
						?>
							<i class="fa like">
								<b class="" data-note="1">&#xf08a;</b><b class="" data-note="2">&#xf08a;</b><b class="" data-note="3">&#xf08a;</b><b class="" data-note="4">&#xf08a;</b><b class="" data-note="5">&#xf08a;</b>
							</i>
						<?php
						}elseif ($m > 0) { ?>
							<i class="fa like">
								<?php
									for ($i=1; $i <= $m+1; $i++) {
										echo('<b class="complete" data-note="'.$i.'">&#xf004;</b>');
									}
									for ($y=5; $y >= $i; $y--) {
										echo('<b class="" data-note="'.$y.'">&#xf08a;</b>');
									}
								?>
							</i>
						<?php }	?>
					</i>
					<i class="fa fav ">
						<b class="">&#xf006;</b>
						<span><?=$fav; ?></span>
					</i>
					<i class="fa comment">
						<b class="">&#xf0e5;</b>
						<span><?=$nbcomment; ?></span>
					</i>
				</span>
				<p id="price">
					<span class="price-main"><?=$reponse['prix_euro']; ?></span>
					<span class="price-cent"><?php if($reponse['prix_cent']!='0') {echo $reponse['prix_cent'];} ?></span>
					<span class="price-currency">€</span>
				</p>
			</div>
		</div>

		<div class="col-12 description">
			<div class="col-6">
				<h2><i class="fa fa-fw">&#xf059;</i>Qui suis-je ?</h2>
				<p><?=$reponse['qui'] ?></p>
			</div>
			<div class="col-6">
				<h2><i class="fa fa-fw">&#xf091;</i>Expérience</h2>
				<p><?=$reponse['experience']; ?></p>
			</div>
			<!-- <div class="col-12 dispo">
				<h2>Mes disponibilités</h2>
				<div class="dashboardcalendar"></div>
			</div> -->
			<div class="col-12 avis">
				<h2>Avis des parents</h2>
				<ul class="col-12">
					<?php
					$data = false;
						$comment_bs = $connexion->query('SELECT nap_comments.comment, nap_comments.date_comment, nap_comments.note, nap_comments.parentId, nap_comments.note, nap_users.photo, nap_users.firstname
							FROM nap_comments
							INNER JOIN nap_users
							ON nap_comments.babysitterId = '.$userId.'
							AND nap_comments.parentId = nap_users.id
							ORDER BY nap_comments.date_comment DESC
						');

						while ($commentaires = $comment_bs->fetch()) {
							$data = true;
							$i = 1;
							$y = 5;

							$commentDate = explode('-', $commentaires['date_comment']);
							$commentDateDay = $commentDate[2];
							$commentDateMonth = $commentDate[1];
							$commentDateYear = $commentDate[0];
					?>
					<li>
						<img src="img/profils/<?php echo $commentaires['photo']; ?>" alt="Photo de <?php echo $commentaires['firstname']; ?>">
						<div class="commentaire">
							<span class="nom"><?php echo $commentaires['firstname']; ?></span>
							<?php if ($commentaires['note'] > 0) { ?>
							<i class="fa like">
								<?php
									for ($i=1; $i <= $commentaires['note']; $i++) {
										echo('<b class="complete">&#xf004;</b>');
									}
									for ($y=5; $y >= $i; $y--) {
										echo('<b class="">&#xf08a;</b>');
									}
								?>
							</i>
							<?php } ?>
							<span class="date"><?echo $commentDateDay.' '.month($commentDateMonth).' '.$commentDateYear; ?></span>
							<p><?php echo $commentaires['comment']; ?></p>
						</div>
					</li>
					<?php }

					if($data == false){
				?>
				<li class="no-demande">Il n'y a pas encore de commentaires de parents.</li>
				<?php } ?>
				</ul>
			</div>
		</div>
	</div>
	<?php
		}
	 ?>
<?php include('inc/script.php'); ?>
</body>




</html>












