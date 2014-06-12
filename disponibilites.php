<?php
	session_start();
	include('inc/connexion.inc.php');
	include('inc/dispos.inc.php');
	$pageId = 8;
	if(!isset($_SESSION['logged_in'])){
		header('location: inscription.php');
	}
?>
<!DOCTYPE html>
<html>
<?php include('inc/head.php'); ?>
<body>
	<?php
		include('inc/header.php');
	?>
		<div class="col-9 dispos" id="content">
			<div class="php">
				<?php
					$date = new Date();
					$year = date('Y');
					$events = $date->getEvents($year);
					$dispos = $date->getDispos($year);
					$dates = $date-> getAll($year);
					$currentMonth = date('n');
					$prevMonth = $currentMonth -1;
					$nextMonth = $currentMonth +1;


				?>
			</div>
			<div class="col-8 calendar">
				<h2>Mon calendrier</h2>
				<div class="generate-calendar">
					<div class="periods">
						<div class="year"><?php echo $year; ?></div>
						<div class="months">
							<ul>
								<?php
									foreach($date->months as $id=>$m){
								?>
								<li><a href="#" id="linkMonth<?php echo $id+1; ?>"><?php echo utf8_encode(utf8_decode($m)); ?></a></li>
								<?php } ?>
							</ul>
						</div>
						<?php $dates = current($dates); ?>
						<?php foreach ($dates as $m => $days) {
						?>
							<div class="month" id="month<?php echo $m;  ?>">
								<table>
									<thead>
										<tr>
											<?php foreach ($date->days as $d) { ?>
												<th><?php echo substr($d,0,3); ?></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<?php $end = end($days); foreach ($days as $d=>$w) { ?>
											<?php $time = strtotime($year.'-'.$m.'-'.$d); ?>
												<?php if ($d == 1) { ?>
													<td colspan="<?php echo $w-1; ?>"></td>
												<?php } ?>

												<td <?php if($time == strtotime(date('Y-m-d'))) {?> class="today"<?php	} ?> >
													<div class="relative">
														<div class="day"><?=$d; ?></div>
													</div>
													<div class="daytitle">
														<?php echo $date->days[$w-1].' '.$d.' '.$date->months[$m-1]; ?>

													</div>
													<ul class="events">
														<?php if (isset($dispos[$time])) {
															foreach ($dispos[$time] as $e) {
																// $dayEvent = "<li class='event day'".$d.'>'.$e.'</li>';
																// $dayEvent = "<pre>".print_r($events)."</pre>";
																?>

																	<li class="dispo day<?=$d ?>"><?php
																		$h = str_split($e, 2);
																		echo($h[0].':'.$h[1]);
																	?></li>
																<?php
															}
														} ?>
														<?php if (isset($events[$time])) {
															foreach ($events[$time] as $e) {
																// $dayEvent = "<li class='event day'".$d.'>'.$e.'</li>';
																// $dayEvent = "<pre>".print_r($events)."</pre>";
																?>

																	<li class="event day<?=$d ?>"><?php echo($e);?></li>
																<?php
															}
														} ?>

													</ul>
												</td>

												<?php if($w == 7) { ?>
													</tr><tr>
												<?php } ?>
											<?php } ?>
											<?php if ($end != 7) { ?>
												<td colspan="<?php echo 7-$end; ?>"></td>
											<?php } ?>
										</tr>
									</tbody>
								</table>
							</div>
						<?php } ?>


					</div>
				</div>
			</div>
			<div class="col-4 calendar-form">
				<h2>Détails</h2>
				<div class="details" id="form_dispos">
					<ul class="date"></ul>
					<ul class="day-details"></ul>
					<form method="post" class="becomeFree">
							<legend>Je suis disponible</legend>
							<div>
								<i>De</i>
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
							</div>
							<div>
								<i>À</i>
								<select name="heure_fin_dispo" id="heure_fin_dispo">
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
								<select name="min_fin_dispo" id="min_fin_dispo">
									<option value="00">00</option>
									<option value="15">15</option>
									<option value="30">30</option>
									<option value="45">45</option>
								</select>
							</div>
							<p class="erreurs" data-erreurs="heure">heure</p>
							<img class="loader" src="img/loader.gif" alt="loader" style="display: none;">
							<input type="submit" value="Enregistrer"/>
						</form>
				</div>


			</div>
		</div>


	<?php include('inc/script.php'); ?>
	<script>
		$(document).ready(function() {

			$('.month').hide();
			$('#month<?php echo $currentMonth; ?>').show();
			$('.months a#linkMonth<?php echo $currentMonth; ?>').parent('li').addClass('active');
			$('.months a#linkMonth<?php echo $prevMonth; ?>').parent('li').addClass('prev');
			$('.months a#linkMonth<?php echo $nextMonth; ?>').parent('li').addClass('next');
			$('.months ul li').css('display', 'none');
			$('.months ul .prev, .months ul .active, .months ul .next').css('display', 'block');

			$('li.dispo').parent('ul').css({borderColor: '#a6d132'});
			$('li.dispo').parents('td').find('.relative .day').addClass('free');
			$('li.dispo').parent('ul').append('<li class="dispo delete"><a href="#"><i class="fa">&#xf014;</i></a></li>');

			$('li.event').parent('ul').css({borderColor: '#ff4b4b'});
			$('li.event').parents('td').find('.relative .day').addClass('blocked');

			var current = <?php echo $currentMonth; ?>;
			$('.months a').click(function(e) {
				e.preventDefault();
				var month = $(this).attr('id').replace('linkMonth', '');

				if(month != current) {
					$('#month'+current).fadeOut(200, function(){
						$('#month'+month).fadeIn();
					});

					$('.months li').removeClass('active prev next');
					$(this).parent('li').prev('li').addClass('prev');
					$(this).parent('li').next('li').addClass('next');
					$(this).parent('li').addClass('active');

					$('.months ul li').css('display', 'none');
					$('.months ul .prev, .months ul .active, .months ul .next').css('display', 'block');

					current = month;
				}
			});


			date = $('.month td.today').children('.daytitle').text();
			date = $.trim(date);
			$('.calendar-form .date').html('<li>'+date+'</li>');
			var text;
			text = $('.today ul.events').html();
			text = $.trim(text);

			dispos();

			function dispos() {
				if(text==''){
					$('.calendar-form .day-details').html('');
					$('.calendar-form form.becomeFree').css('display', 'block');
				}else{
					$('.calendar-form form.becomeFree').css('display', 'none');
					$('.calendar-form .day-details').html(text);
				}
			}


			$('.month td').click(function() {

				date = $(this).children('.daytitle').text();
				$('.calendar-form .date').html(date);

				text = $(this).children('ul.events').html();
				text = $.trim(text);
				dispos();
			});

			$('.month td').click(function() {
				day = $(this).find('.day');
				$('.calendar-form .date').html('');
				if ($(this).find('.day').hasClass('dateSelect')){
					day.removeClass('dateSelect');
					writeDate();
				}else if(($(this).find('.day').hasClass('blocked')) || ($(this).find('.day').hasClass('free'))){
					date = day.parents('td').find('.daytitle').text();
					$('.calendar-form .date').html('<li>'+date+'</li>');
				}else{
					day.addClass('dateSelect');
					writeDate();
				}

				function writeDate() {
					$('.dateSelect').each(function() {
						date = $(this).parents('td').find('.daytitle').text();
						date = '<li>'+ $.trim(date)+'</li>';
						$('.calendar-form .date').append(date);
					});

				}

			});



		});
	</script>
</body>
</html>












