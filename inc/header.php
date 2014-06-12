<?php
	session_start();
	if(!(isset($_SESSION['logged_in']))){
		header('location: inc/logout.php');
	}
	include('connexion.inc.php');
	$account_type = $_SESSION['account_type'];
	$parentId = $_SESSION['id'];
	$infos_user = $connexion->query('SELECT * FROM nap_users WHERE id = '.$parentId);
	$reponseparent = $infos_user->fetch();

?>
<header id="header">
	<h1><a href="#">Nappy</a></h1>
	<nav>
		<ul>
			<?php if($_SESSION['account_type'] == '2' ){ ?>
			<!-- <li>
				<a class="fa" id="header-button-search" href="#">&#xf002; <span>Trouver un babysitter</span></a>
			</li> -->
			<?php } ?>
			<li><a class="fa button-notif" href="#">&#xf0f3; <i class="notifications"></i></a></li>
			<!-- <li><a class="fa" href="profil.php">&#xf007;</a></li> -->
			<li><a class="fa" href="inc/logout.php" data-no-instant>&#xf08b;</a></li>
		</ul>
	</nav>
	<?php if ($account_type == 2) { ?>
	<div id="header-search" class="col-12">
		<form method="POST" class="col-12 form-search">

			<div class="col-8 checks">
				<span>Pour</span>

				<?php
				$infos_child = $connexion->query('SELECT firstname, birth, id FROM nap_children WHERE parentId = '.$parentId);
					while($reponseChild = $infos_child->fetch()) {
				?>
					<label class="noselect" for="<?=$reponseChild['firstname'];?>"><span class="fa fa-fw">&#xf00c;</span><?=$reponseChild['firstname'];?></label>
					<input type="checkbox" id="<?=$reponseChild['firstname'];?>" name="children" data-childid="<?=$reponseChild['id'];?>" data-birth="<?=$reponseChild['birth'];?>" value="<?=$reponseChild['firstname'];?>">

				<?php } ?>
			</div>
			<div class="col-8">
				<span>Le</span>
				<input type="text" id="datepicker" placeholder="date"/>
				<!-- <label>date</label> -->

				<span>de</span>
				<select name="heure_debut_dispo" id="heure_debut_dispo">
					<option value="00">00</option>
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
				</select>
				<i>h</i>
				<select name="min_debut_dispo" id="min_debut_dispo">
					<option value="00">00</option>
					<option value="15">15</option>
					<option value="30">30</option>
					<option value="45">45</option>
				</select>

				<span>à</span>
				<select name="heure_debut_dispo" id="heure_fin_dispo">
					<option value="00">00</option>
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
				</select>
				<i>h</i>
				<select name="min_debut_dispo" id="min_fin_dispo">
					<option value="00">00</option>
					<option value="15">15</option>
					<option value="30">30</option>
					<option value="45">45</option>
				</select>
			</div>
			<div class="col-8">
				<span>À</span>
				<input id="geocomplete" class="adresse complete" type="text" placeholder="Lieu du babysitting" value="<?=$reponseparent['adress']; ?>"/>
				<!-- <label>Adresse</label> -->
			</div>
			<div class="col-4 submit">
				<input type="submit" value="Trouver mon &#10;babysitter !" data-no-instant>
			</div>
		</form>
	</div>
	<?php } ?>
	<ul id="notifications">

	</ul>

</header>
<div class="col-3" id="sidebar">
	<a class="profil" href="profil.php?id=<?=$_SESSION['id']; ?>">
		<img src="img/profils/<?php echo $_SESSION['photo'];?>" alt="Photo <?php echo $_SESSION['firstname']; echo ' '.$_SESSION['name'];
		?>">
		<span>
			<?php
				echo $_SESSION['firstname'];
				echo ' '.$_SESSION['name'];
			?>
		</span>
	</a>
	<nav>
		<ul>
			<li><a <?php if($pageId==1){ echo "class='active'";} ?> href="index.php"><i class="fa fa-fw">&#xf133;</i><span>Babysittings</span></a></li>
			<li><a <?php if($pageId==4){ echo "class='active'";} ?> href="search.php"><i class="fa fa-fw">&#xf002;</i><span>Les babysitters</span></a></li>
			<?php if($account_type == 2) { ?>
				<li><a <?php if($pageId==5){ echo "class='active'";} ?> href="favoris.php"><i class="fa fa-fw">&#xf005;</i><span>babysitters favoris</span></a></li>
			<?php }elseif($account_type == 1) { ?>
				<li><a <?php if($pageId==8){ echo "class='active'";} ?> href="disponibilites.php"><i class="fa fa-fw">&#xf133;</i><span>Mes disponibilités</span></a></li>
			<?php } ?>
			<li class="side_demandes"><a <?php if($pageId==6){ echo "class='active'";} ?> href="demandes.php"><i class="fa fa-fw">&#xf0ac;</i><span>Mes demandes <b></b></span></a></li>
			<li><a data-no-instant <?php if($pageId==7){ echo "class='active'";} ?> href="edit-profil.php"><i class="fa fa-fw">&#xf013;</i><span>profil</span></a></li>
		</ul>
	</nav>
</div>

<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>