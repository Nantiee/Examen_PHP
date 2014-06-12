<?php
	session_start();
	$pageId = 5;
	$userId = $_SESSION['id'];
	include('inc/connexion.inc.php');
	include('inc/functions.inc.php');
?>
<!DOCTYPE html>
<html>
<?php include('inc/head.php'); ?>
<body>
	<?php include('inc/header.php'); ?>
	<div class="col-9" id="content">
		<div class="col-12" id="result">
			<h2>Mes babysitters préféres</h2>
			<ul>
				<?php
					$search_favoris = $connexion->query('SELECT nb_fav FROM nap_users WHERE id = '.$userId);
					$r = $search_favoris->fetch();

					$fav = explode(',', $r['nb_fav']);

					$where = '';

					for ($i=0; $i < count($fav); $i++) {
						if ($where == '') {
							$where = 'id = '.$fav[$i];
						}else{
							$where = $where.' || id = '.$fav[$i];
						}
					}


					$fav_bs = $connexion->query("SELECT * FROM nap_users WHERE $where ORDER BY last_connected DESC");

					while ($babysitter = $fav_bs->fetch()) {
						$n = 0;
						$i = 1;

						$notes = explode(',', $babysitter['avis_bs']);
						for ($i=0; $i < count($notes); $i++) {
							$n = $n + $notes[$i];
							$m = $n/count($notes);
						}


				?>

				<li data-babysitter="<?php echo $babysitter['id'];?>">
					<span class="recherche-photo col-2">
						<a href="profil.php?id=<?php echo $babysitter['id'];?>">
							<img src="img/profils/<?php echo $babysitter['photo'];?>" alt="Photo de <?php echo $babysitter['firstname'];?>">
						</a>
					</span>
					<div class="col-6 description">
						<span><a href="profil.php?id=<?php echo $babysitter['id'];?>"><strong><?php echo $babysitter['firstname'];?></strong></a><?php if(!(age($babysitter['birth']) == $year)){echo age($babysitter['birth']).' ans';} ?><b><?php echo $babysitter['phone'];?></b></span>
						<p><?php echo $babysitter['qui'];?></p>
					</div>
					<div class="col-4 infos">
						<div class="favcom">
							<i class="fa fav">
								<?php if (($babysitter['nb_fav'] == '') || ($babysitter['nb_fav'] == '0')) {
								?>
									<b class="">&#xf006;</b>
									<span class="number">0</span>
								<?php
								}else{ ?>
									<b class="complete">&#xf005;</b>
									<span class="number"><?php echo $babysitter['nb_fav'];?></span>
								<?php } ?>
							</i>
							<i class="fa comment">
								<?php
								if (($babysitter['nb_com'] == '') || ($babysitter['nb_com'] == '0')) {
								?>
									<b class="">&#xf075;</b>
									<span class="number">0</span>
								<?php
								}else{ ?>
									<b class="complete">&#xf075;</b>
									<span class="number"><?php echo $babysitter['nb_com'];?></span>
								<?php } ?>

							</i>
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
						</div>
						<p id="price">
							<span class="price-main"><?php echo $babysitter['prix_euro'];?></span>
							<span class="price-cent"><?php if($babysitter['prix_cent']!='0') {echo $babysitter['prix_cent'];} ?></span>
							<span class="price-currency">€</span>
						</p>
						<button>Contacter <?php echo $babysitter['firstname'];?></button>

					</div>
					<div class="bonuscomment">
						<?php
							$search_comments = $connexion->query("SELECT * FROM nap_comments WHERE babysitterId = ". $babysitter['id']);
							while ($comments = $search_comments->fetch()) {

							$commentDate = explode('-', $comments['date_comment']);
							$commentDateYear = $commentDate[0];
							$commentDateMonth = $commentDate[1];
							$commentDateDay = $commentDate[2];

							$search_parent = $connexion->query("SELECT firstname, photo FROM nap_users WHERE id = ". $comments['parentId']);
							$parent = $search_parent->fetch();
						?>
						<div class="parent-comment col-12">
							<p class="col-8"><?php echo $comments['comment']; ?></p>
							<div class="col-4 commenteur">
								<img src="img/profils/<?php echo $parent['photo']; ?>" alt="Photo de <?php echo $parent['firstname']; ?>">
								<p><?php echo $parent['firstname']; ?><br>
								<span class="date"><?echo $commentDateDay.' '.month($commentDateMonth).' '.$commentDateYear; ?></span></p>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="bonusdemande col-12" data-babysitter="<?php echo $babysitter['id'];?>">
						<div class="side">
							<img src="img/profils/<?php echo $_SESSION['photo'];?>" alt="Photo <?php echo $_SESSION['firstname']; echo ' '.$_SESSION['name']; ?>">
							<p><?php echo $_SESSION['firstname'];?></p>
							<span class="date" data-date="<?php echo $year.'-'.$month.'-'.$day; ?>"><?php echo $day.' '.month($month).' '.$year; ?></span>
						</div>
						<?php if(!(empty($all_babysitters))){ ?>
							<ul class="infos_demande">
								<li class="date">
									<i class="fa">&#xf133;</i>
									<span><?echo $demandeDateDay.' '.month($demandeDateMonth).' '.$demandeDateYear; ?></span>
								</li>
								<li class="heure">
									<i class="fa">&#xf017;</i>
									<span><?php echo($recherche[2].':'.$recherche[3].' - '.$recherche[4].':'.$recherche[5]); ?></span>
								</li>
								<li class="adresse">
									<i class="fa">&#xf041;</i>
									<span><?=$recherche[6]; ?></span>
								</li>
								<li class="enfants">
									<i class="fa">&#xf09b;</i>
									<span><?php
										$affichage = $recherche[0][0].' ('.age($recherche[7][0]).' ans)';
										if (count($recherche[0]) > 1) {
											for ($i=1; $i <= count($recherche[0])-1; $i++) {
												$affichage = $affichage.', '.$recherche[0][$i].' ('.age($recherche[7][$i]).' ans)';
											}
											echo $affichage;
										}else{echo $affichage;}
									?></span>
								</li>
								<li class="telephone">
									<i class="fa">&#xf095;</i>
									<span><?php echo $_SESSION['phone'];?></span>
								</li>
							</ul>
						<?php } ?>
						<div class="message">
							<form method="post" class="send_demande">
								<label for="message">Ajouter un message</label>
								<textarea name="message" placeholder="Salut <?php echo $babysitter['firstname'];?>" id="message" cols="30" rows="7" required></textarea>
								<input type="submit" class="valider" value="envoyer la demande">
							</form>
						</div>
					</div>
				</li>

				<?php } ?>
			</ul>
		</div>
	</div>
<?php include('inc/script.php'); ?>
</body>

</html>












