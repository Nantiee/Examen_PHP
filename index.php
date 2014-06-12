<?php
	session_start();
	$pageId = 1;

	include('inc/functions.inc.php');

	$today = date('Y-m-d');
	$date = explode('-', $today);
	$thisYear = $date[0];
	$thisMonth = $date[1];
	$thisDay = $date[2];

	$data = false;

	$account_type = $_SESSION['account_type'];
	$userId = $_SESSION['id'];

	function heure($value)
	{
		$heure = substr($value, 0, 2);
		$min = substr($value, 2);
		return $horaire = $heure.':'.$min;
	}
?>
<!DOCTYPE html>
<html>
<?php include('inc/head.php'); ?>
<body>
	<?php include('inc/header.php'); ?>
	<div class="col-9 next" id="content">
		<div id="next">
			<ul class="babysitting-tabs">
				<li class="bs-tab babysitting-next active-tab">
					<h2>Babysittings prévus</h2>


				</li>
				<li class="bs-tab babysitting-last">
					<h2>Babysittings passés</h2>

				</li>
			</ul>
			<ul class="babysittingList babysitting-next">
				<!-- Babysitter -->
				<?php if($_SESSION['account_type'] == '1' ){
					$next_bs = $connexion->query("SELECT * FROM nap_babysittings WHERE babysitterID = ".$userId." AND datebs >= '".$today."'");

					while ($babysitting = $next_bs->fetch()) {
						$data = true;
						$bsDate = explode('-', $babysitting['datebs']);
						$bsDateYear = $bsDate[0];
						$bsDateMonth = $bsDate[1];
						$bsDateDay = $bsDate[2];

						$parent_bs = $connexion->query("SELECT * FROM nap_users WHERE id = ".$babysitting['parentId']."  ");
						$parent = $parent_bs->fetch();
					?>
					<li class="babysitter">
						<span class="bs-photo col-2">
							<a href="profil.php?id=<?php echo $parent['id'];?>">
								<img src="img/profils/<?php echo $parent['photo']; ?>" alt="Photo de <?php echo $parent['firstname']; ?>">
							</a>
						</span>
						<div class="details">
							<span><i class="fa fa-fw">&#xf09b;</i><?php echo $babysitting['children']; ?></span>
							<span><i class="fa fa-fw">&#xf041;</i><?php echo $babysitting['adressbs']; ?></span>
						</div>
						<div class="details">
							<span><i class="fa fa-fw">&#xf133;</i><?echo $bsDateDay.' '.month($bsDateMonth).' '.$bsDateYear; ?></span>
							<span><i class="fa fa-fw">&#xf017;</i><?php echo heure($babysitting['debut']).' - '.heure($babysitting['fin']); ?></span>
							<span><i class="fa fa-fw">&#xf095;</i><?php echo $babysitting['phone']; ?></span>
						</div>
					</li>
					<?php }

					if($data == false){
					?>
					<li class="no-demande">Vous n'avez pas de babysittings prévus.</li>
					<?php } ?>

				<?php }elseif($_SESSION['account_type'] == '2' ){
					$next_bs = $connexion->query("SELECT * FROM nap_babysittings WHERE parentID = ".$userId." AND datebs >= '".$today."'");

					while ($babysitting = $next_bs->fetch()) {
						$data = true;
						$bsDate = explode('-', $babysitting['datebs']);
						$bsDateYear = $bsDate[0];
						$bsDateMonth = $bsDate[1];
						$bsDateDay = $bsDate[2];

						$babysitter_bs = $connexion->query("SELECT * FROM nap_users WHERE id = ".$babysitting['babysitterId']."  ");
						$babysitter = $babysitter_bs->fetch();
					?>
					<li>
						<span class="bs-photo col-2">
							<a href="profil.php?id=<?php echo $babysitter['id'];?>">
								<img src="img/profils/<?php echo $babysitter['photo']; ?>" alt="Photo de <?php echo $babysitter['firstname']; ?>">
							</a>
						</span>
						<div class="details parent">
							<span><i class="fa fa-fw">&#xf007;</i><?php echo $babysitter['firstname']; ?></span>
							<span><i class="fa fa-fw">&#xf091;</i><?php if($babysitter['birth'] != '0000-00-00') {echo age($babysitter['birth']).' ans';}else{echo 'Âge non indiqué';} ?></span>
							<span><i class="fa fa-fw">&#xf095;</i><?php echo $babysitter['phone']; ?></span>
						</div>
						<div class="details parent">
							<span><i class="fa fa-fw">&#xf09b;</i><?php echo $babysitting['children']; ?></span>
							<span><i class="fa fa-fw">&#xf133;</i><?echo $bsDateDay.' '.month($bsDateMonth).' '.$bsDateYear; ?></span>
							<span><i class="fa fa-fw">&#xf017;</i><?php echo heure($babysitting['debut']).' - '.heure($babysitting['fin']); ?></span>
						</div>
						<?php
							$babysittingId = $babysitting['id_babysittings'];

							$search_note = $connexion->query("SELECT nb_fav FROM nap_users WHERE id = ".$userId);
							$fav = $search_note->fetch();
							$favs = explode(',', $fav['nb_fav']);

							$favori = 0;
							for ($i=0; $i < count($favs); $i++) {
								if ($favs[$i] == $babysitting['babysitterId']) {
									$favori = 1;
								}
							}

						?>
						<div class="details annotations">
							<i class="fa comment">
								<b <?php if ($babysitter['nb_com'] > 0) {echo('class="complete"');}else{echo('class="vide"');} ?> >&#xf075;</b>
							</i>
							<i class="fa fav">
								<?php if ($favori == 0) { ?>
									<b data-fav="0">&#xf006;</b>
								<?php }elseif ($favori == 1) { ?>
								<b  class="complete" data-fav="1">&#xf005;</b>
								<?php } ?>
							</i>
							<?php
								$search_note = $connexion->query("SELECT note FROM nap_comments WHERE babysittingId = ".$babysittingId);
								$comment = $search_note->fetch();

								if (!(isset($comment['note'])) || ($comment['note'] == '0')) {
							?>
								<i class="fa like noter">
									<b class="" data-note="1">&#xf08a;</b><b class="" data-note="2">&#xf08a;</b><b class="" data-note="3">&#xf08a;</b><b class="" data-note="4">&#xf08a;</b><b class="" data-note="5">&#xf08a;</b>
								</i>
							<?php
							}elseif ($comment['note'] > 0) { ?>
								<i class="fa like">
									<?php
										for ($i=1; $i <= $comment['note']; $i++) {
											echo('<b class="complete" data-note="'.$i.'">&#xf004;</b>');
										}
										for ($y=$i; $y <= 5; $y++) {
											echo('<b class="" data-note="'.$y.'">&#xf08a;</b>');
										}
									?>
								</i>
							<?php }	?>
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
					</li>
					<?php }

					if($data == false){
					?>
					<li class="no-demande">Vous n'avez pas de babysittings prévus.</li>
					<?php } ?>
				<?php } ?>
			</ul>


			<ul class="babysittingList babysitting-last activeList">
				<!-- Babysitter -->
				<?php if($_SESSION['account_type'] == '1' ){
					$next_bs = $connexion->query("SELECT * FROM nap_babysittings WHERE babysitterID = ".$userId." AND datebs <= '".$today."'");
					while ($babysitting = $next_bs->fetch()) {
						$data = true;
						$bsDate = explode('-', $babysitting['datebs']);
						$bsDateYear = $bsDate[0];
						$bsDateMonth = $bsDate[1];
						$bsDateDay = $bsDate[2];

						$parent_bs = $connexion->query("SELECT * FROM nap_users WHERE id = ".$babysitting['parentId']."  ");
						$parent = $parent_bs->fetch();
				?>

				<li data-babysitting="<?php echo $babysitting['id_babysittings']; ?>">
					<span class="bs-photo col-2">
						<a href="profil.php?id=<?php echo $parent['id'];?>">
							<img src="img/profils/<?php echo $parent['photo']; ?>" alt="Photo de <?php echo $parent['firstname']; ?>">
						</a>
					</span>
					<div class="details">
							<span><i class="fa fa-fw">&#xf09b;</i><?php echo $babysitting['children']; ?></span>
							<span><i class="fa fa-fw">&#xf041;</i><?php echo $babysitting['adressbs']; ?></span>
						</div>
						<div class="details">
							<span><i class="fa fa-fw">&#xf133;</i><?echo $bsDateDay.' '.month($bsDateMonth).' '.$bsDateYear; ?></span>
							<span><i class="fa fa-fw">&#xf017;</i><?php echo heure($babysitting['debut']).' - '.heure($babysitting['fin']); ?></span>
							<span><i class="fa fa-fw">&#xf095;</i><?php echo $babysitting['phone']; ?></span>
						</div>

					<div class="details annotations">
						<?php
						$check_notes = $connexion->query('SELECT note, favoris, comment FROM nap_comments WHERE babysittingId = '.$babysitting['id_babysittings']);
						$comment = $check_notes->fetch();
					?>
						<i class="fa comment">
							<b <?php if ($comment['comment'] != '') {
								echo('class="complete"');
							} ?>>&#xf075;</b>
						</i>
						<i class="fa fav">
							<?php if ($comment['favoris'] == 0) { ?>
								<b data-fav="0">&#xf006;</b>
							<?php }elseif ($comment['favoris'] == 1) { ?>
							<b  class="complete" data-fav="1">&#xf005;</b>
							<?php } ?>
						</i>
						<?php
							if (!(isset($comment['note'])) || ($comment['note'] == '0')) {
						?>
							<i class="fa like">
								<b class="" data-note="1">&#xf08a;</b><b class="" data-note="2">&#xf08a;</b><b class="" data-note="3">&#xf08a;</b><b class="" data-note="4">&#xf08a;</b><b class="" data-note="5">&#xf08a;</b>
							</i>
						<?php
						}elseif ($comment['note'] > 0) { ?>
							<i class="fa like">
								<?php
									for ($i=1; $i <= $comment['note']; $i++) {
										echo('<b class="complete" data-note="'.$i.'">&#xf004;</b>');
									}
									for ($y=5; $y >= $i; $y--) {
										echo('<b class="" data-note="'.$y.'">&#xf08a;</b>');
									}
								?>
							</i>
						<?php }	?>
					</div>
					<div class="bonuscomment col-12">
						<?php
							$babysittingId = $babysitting['id_babysittings'];

							if ($comment['comment_parent'] != '') {
							$search_parent = $connexion->query("SELECT * FROM nap_users WHERE id = ".$parentId);
							$parent_comment = $search_parent->fetch();


							$bsCommentDate = explode('-', $comment['date_comment_bs']);
							$bsCommentDateYear = $bsCommentDate[0];
							$bsCommentDateMonth = $bsCommentDate[1];
							$bsCommentDateDay = $bsCommentDate[2];
						?>
							<div class="parent-comment col-12">
								<p class="col-8"><?php echo $comment['comment_parent']; ?></p>
								<div class="col-4 commenteur">
									<img src="img/profils/<?php echo $parent_comment['photo'];?>" alt="Photo <?php echo $parent_comment['firstname']; echo ' '.$_SESSION['name']; ?>">
									<p><?php echo $parent_comment['firstname']; ?><br>
									<span class="date"><?php echo $bsCommentDateDay.' '.month($bsCommentDateMonth).' '.$bsCommentDateYear; ?></span></p>
								</div>
							</div>

						<?php } ?>
					</div>
				</li>
				<?php }

					if($data == false){
					?>
					<li class="no-demande">Vous n'avez pas de babysittings prévus.</li>
					<?php } ?>
				<!-- Parent -->

				<?php
					}elseif($_SESSION['account_type'] == '2' ){

						$next_bs = $connexion->query("SELECT * FROM nap_babysittings WHERE parentID = ".$userId." AND datebs <= '".$today."'");
						while ($babysitting = $next_bs->fetch()) {
							$data = true;
							$bsDate = explode('-', $babysitting['datebs']);
							$bsDateYear = $bsDate[0];
							$bsDateMonth = $bsDate[1];
							$bsDateDay = $bsDate[2];

							$babysitter_bs = $connexion->query("SELECT * FROM nap_users WHERE id = ".$babysitting['babysitterId']."  ");
							$babysitter = $babysitter_bs->fetch();
				?>
				<li data-babysitting="<?php echo $babysitting['id_babysittings']; ?>" data-babysitterid="<?php echo $babysitter['id'];?>">
					<span class="bs-photo col-2">
						<a href="profil.php?id=<?php echo $babysitter['id'];?>">
							<img src="img/profils/<?php echo $babysitter['photo']; ?>" alt="Photo de <?php echo $babysitter['firstname']; ?>">
						</a>
					</span>
					<div class="details parent">
						<span><i class="fa fa-fw">&#xf007;</i><?php echo $babysitter['firstname']; ?></span>
						<span><i class="fa fa-fw">&#xf091;</i>21 ans</span>
						<span><i class="fa fa-fw">&#xf095;</i><?php echo $babysitter['phone']; ?></span>
					</div>
					<div class="details parent">
						<span><i class="fa fa-fw">&#xf09b;</i><?php echo $babysitting['children']; ?></span>
						<span><i class="fa fa-fw">&#xf133;</i><?echo $bsDateDay.' '.month($bsDateMonth).' '.$bsDateYear; ?></span>
						<span><i class="fa fa-fw">&#xf017;</i><?php echo heure($babysitting['debut']).' - '.heure($babysitting['fin']); ?></span>
					</div>
					<?php
						$babysittingId = $babysitting['id_babysittings'];
						$search_comment = $connexion->query("SELECT * FROM nap_comments WHERE babysittingId = ".$babysittingId);
						$comment = $search_comment->fetch();
						$babysitterId = $babysitting['babysitterId'];
					?>

					<div class="details annotations parent">
						<i class="fa comment">
							<b <?php if ($comment['comment'] != '') {
								echo('class="complete"');
							} ?>>&#xf075;</b>
						</i>
						<i class="fa fav">
							<?php if ($comment['favoris'] == 0) { ?>
								<b data-fav="0">&#xf006;</b>
							<?php }elseif ($comment['favoris'] == 1) { ?>
							<b  class="complete" data-fav="1">&#xf005;</b>
							<?php } ?>
						</i>
						<?php
							if (!(isset($comment['note'])) || ($comment['note'] == '0')) {
						?>
							<i class="fa like noter">
								<b class="" data-note="1">&#xf08a;</b><b class="" data-note="2">&#xf08a;</b><b class="" data-note="3">&#xf08a;</b><b class="" data-note="4">&#xf08a;</b><b class="" data-note="5">&#xf08a;</b>
							</i>
						<?php
						}elseif ($comment['note'] > 0) { ?>
							<i class="fa like">
								<?php
									for ($i=1; $i <= $comment['note']; $i++) {
										echo('<b class="complete" data-note="'.$i.'">&#xf004;</b>');
									}
									for ($y=$i; $y <= 5; $y++) {
										echo('<b class="" data-note="'.$y.'">&#xf08a;</b>');
									}
								?>
							</i>
						<?php }	?>
					</div>
					<div class="bonuscomment col-12">
						<?php


							if ($comment['comment'] != '') {
								$commentDate = explode('-', $comment['date_comment']);
								$commentDateYear = $commentDate[0];
								$commentDateMonth = $commentDate[1];
								$commentDateDay = $commentDate[2];
						?>
							<div class="answerComment">
								<div class="col-4 commenteur">
									<img src="img/profils/<?php echo $_SESSION['photo'];?>" alt="Photo <?php echo $_SESSION['firstname']; echo ' '.$_SESSION['name']; ?>">
									<p><?php echo $_SESSION['firstname'];?><br>
									<span class="date"><?echo $commentDateDay.' '.month($commentDateMonth).' '.$commentDateYear; ?></span></p>
								</div>
								<p class="col-8"><?php echo $comment['comment']; ?></p>
							</div>

						<?php }elseif($comment['comment'] == ''){ ?>
						<div class="answerComment">
							<div class="col-4 commenteur">
								<img src="img/profils/<?php echo $_SESSION['photo'];?>" alt="Photo <?php echo $_SESSION['firstname']; echo ' '.$_SESSION['name']; ?>">
								<p><?php echo $_SESSION['firstname'];?><br>
								<span class="date"><?echo $thisDay.' '.month($thisMonth).' '.$thisYear; ?></span></p>
							</div>
							<form method="POST" class="comParent col-8" data-usertype="parent" data-firstcomment="<?php echo $commentBabysitter; ?>">
								<label for="message">Ajouter un commentaire à ce babysitting</label>
								<textarea name="message" id="message" required></textarea>
								<input type="submit" class="valider" value="Envoyer">
							</form>
						</div>
						<?php } ?>
					</div>
				</li>
				<?php }

					if($data == false){
					?>
					<li class="no-demande">Vous n'avez pas de babysittings passés.</li>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>
	</div>
<?php include('inc/script.php'); ?>
</body>


</html>












