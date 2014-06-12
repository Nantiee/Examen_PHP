<?php session_start();
$pageId = 4;
$account_type = $_SESSION['account_type'];
if ($account_type == 2) {$type = 'parent';}elseif ($account_type == 1) {$type = 'babysitter';}
?>
<!DOCTYPE html>
<html lang="fr">
<?php include('inc/head.php');
?>
<body>
	<?php include('inc/header.php'); ?>
	<div class="col-9 recherche <?php echo $type; ?>" id="content">
		<div class="col-12" id="result">
		<?php include('inc/babysitters.inc.php'); ?>
		</div>
	</div>


<style>header #header-search {display: block;}</style>
<?php include('inc/script.php'); ?>
</body>



</html>












