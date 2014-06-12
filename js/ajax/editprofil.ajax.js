$(document).ready(function() {
	jacqueline = function(time, append, celuila, divers ){
		$('.loader').hide();
		celuila.after(append);
		setTimeout(function(){
			$('p.valid, p.erreur').fadeOut('400', function() {
				$(this).remove();
				$('input[type=submit]').fadeIn();
			});
			divers();
		}, time);

	}

	// ADD CHILD
		$('.edit-blocs .new-child').submit(function(e) {
			e.preventDefault();
			celuila = $(this).find('input[type=submit]');
			celuila.hide();

			child_name = $('#child_name').val();
			child_description = $('#child_description').val();
			form_type = 'new';

			birthDay = $('#child_birth .day').val();
			birthMonth = $('#child_birth .month').val();
			birthYear = $('#child_birth .year').val();

			$.post('inc/child.inc.php', {child_name: child_name, birthDay: birthDay, birthMonth: birthMonth, birthYear: birthYear, child_description: child_description, form_type: form_type}, function(data){
				if (data.reponse !='ajout ok') {
					$.each(data, function(key, val) {
						$('p.erreurs[data-erreurs='+key+']').text(val).slideDown();
					});
					pValid = '<p class="erreur">Il y a des erreurs</p>';
					function divers(){};
					jacqueline(1000, pValid, celuila, divers);

				}else if(data.reponse == "ajout ok"){
					pValid = '<p class="valid">'+child_name+' a été ajouté(e) !</p>';


					function divers(){
						console.log(data);
						$('form.new-child').closest('div.child').after("<div class='child' data-child-id="+data.childId+"><form class='edit-child col-12' method='post'><fieldset class='col-12'><div class='child_name infos-2'><label for='child_name' name='child_name'>Prénom</label><input class='col-4' type='text' id='child_name' placeholder='Prénom' value="+child_name+"></div><div class='child_birth infos-2'><label for='child_birth' name='child_birth'>Date de naissance</label><div id='child_birth' class='datefield'><input id='number1' type='text' class='number day' maxlength='2' size='2' placeholder='JJ' value="+birthDay+"><input id='number2' type='text' class='number month' maxlength='2' size='2' placeholder='MM' value="+birthMonth+"><input id='number3' type='text' class='number year' maxlength='4' size='4' placeholder='AAAA' value="+birthYear+"></div></div><div class='infos-1'><label for='child_description' name='child_description'>Que souhaitez-vous dire à propos de votre enfant ?</label><textarea id='child_description' placeholder='Décrivez votre enfant, pour trouver le babysitter qui lui conviendra.'>"+child_description+"</textarea></div><img class='loader' src='img/loader.gif' alt='loader' style='display: none;''><input type='submit' value='Mettre à jour "+child_name+"'></fieldset></form></div>");
						$('form.new-child').closest('div.child').slideUp();
						$("form.new-child input[type=text], form.new-child textarea").val('');
						$('input[type=submit]').css('visibility', 'visible');
						$('.child .edit-child').slideDown();
						$('.edit-blocs #add-child').slideDown();
					}

					jacqueline(1000, pValid, celuila, divers);
				}

			}, "json");
		});


	// EDIT CHILD
		$('.edit-blocs').on('submit', '.edit-child', function(e) {
			e.preventDefault();

			celuila = $(this).find('input[type=submit]');
			celuila.hide();
			$(this).find('.loader').show();
			child_name = $(this).closest("form").find('#child_name').val();
			child_description = $(this).closest("form").find('#child_description').val();
			child_id = $(this).closest("form").parents('.child').data('child-id');
			form_type = 'edit';

			birthDay = $(this).closest("form").find('#child_birth .day').val();
			birthMonth = $(this).closest("form").find('#child_birth .month').val();
			birthYear = $(this).closest("form").find('#child_birth .year').val();

			$.post('inc/child.inc.php', {child_name: child_name, birthDay: birthDay, birthMonth: birthMonth, birthYear: birthYear, child_description: child_description, child_id: child_id, form_type: form_type}, function(data){
				if (data !='edit ok') {
					$.each(data['erreurs'], function(key, val) {
						celuila.closest('fieldset').find('p.erreurs[data-erreurs='+key+']').text(val).slideDown();
					});
					pValid = '<p class="erreur">Il y a des erreurs</p>';
					function divers(){};
					jacqueline(1000, pValid, celuila, divers);

				}else if(data == "edit ok") {
					console.log('edit');
					pValid = '<p class="valid">'+child_name+' a été mis jour !</p>';
					function divers(){};
					jacqueline(1000, pValid, celuila, divers);
				}
			}, "json");
		});



// EDIT INFOS
	$('.edit-blocs #edit-profil').submit(function(e) {
		e.preventDefault();

		celuila = $(this).find('input[type=submit]');
		celuila.hide();

		$(this).find('.loader').show();
		parent_birth = '0000-00-00';

		parent_firstname = $('#edit_firstname').val();
		parent_name = $('#edit_name').val();
		parent_birth = $('#edit_birth').val();
		parent_password1 = $('#edit_password1').val();
		parent_password2 = $('#edit_password2').val();
		parent_email = $('#edit_email').val();
		parent_phone = $('#edit_phone').val();
		parent_adress = $('#edit_adress').val();

		console.log(parent_birth);

		$.post('inc/profil.inc.php', {
			parent_firstname: parent_firstname,
			parent_name: parent_name,
			parent_birth: parent_birth,
			parent_password1: parent_password1,
			parent_password2: parent_password2,
			parent_email: parent_email,
			parent_phone: parent_phone,
			parent_adress: parent_adress
		}, function(data){
			console.log(data);
			if (data !='ok') {
				$.each(data, function(key, val) {
					$('p.erreurs[data-erreurs='+key+']').text(val).slideDown();
				});
				pValid = '<p class="erreur">Il y a des erreurs</p>';
				function divers(){};
				jacqueline(1000, pValid, celuila, divers);
			} else if(data == "ok") {
				console.log(data);
				pValid = '<p class="valid">Votre profil a été mis jour !</p>';
				function divers(){};
				jacqueline(1000, pValid, celuila, divers);
			}
		}, "json");
	});




// EDIT A SAVOIR
	$('.edit-blocs #aSavoir').submit(function(e) {
		e.preventDefault();

		celuila = $(this).find('input[type=submit]');
		celuila.hide();

		$(this).find('.loader').show();

		parent1 = $('#parent1').val();
		phoneparent1 = $('#phoneparent1').val();
		parent2 = $('#parent2').val();
		phoneparent2 = $('#phoneparent2').val();

		urgence1 = $('#urgence1').val();
		urgencephone1 = $('#urgencephone1').val();
		urgence2 = $('#urgence2').val();
		urgencephone2 = $('#urgencephone2').val();

		docteurname = $('#docteurname').val();
		docteurphone = $('#docteurphone').val();
		docteuradress = $('#docteuradress').val();

		important = $('#important').val();

		console.log(phoneparent2);


		$.post('inc/asavoir.inc.php', {
			parent1: parent1,
			phoneparent1: phoneparent1,
			parent2: parent2,
			phoneparent2: phoneparent2,
			urgence1: urgence1,
			urgencephone1: urgencephone1,
			urgence2: urgence2,
			urgencephone2: urgencephone2,
			docteurname: docteurname,
			docteurphone: docteurphone,
			docteuradress: docteuradress,
			important: important
		}, function(data){
			console.log(data);
			if (data !='ok') {
				$.each(data, function(key, val) {
					$('p.erreurs[data-erreurs='+key+']').text(val).slideDown();
				});
				pValid = '<p class="erreur">Il y a des erreurs</p>';
				function divers(){};
				jacqueline(1000, pValid, celuila, divers);
			} else if(data == "ok") {
				console.log(data);
				pValid = '<p class="valid">Votre profil a été mis jour !</p>';
				function divers(){};
				jacqueline(1000, pValid, celuila, divers);
			}
		}, "json");
	});

	// BABYSITTERS DESCRIPTION
	$('.edit-blocs .bs_description').submit(function(e) {
		e.preventDefault();

		celuila = $(this).find('input[type=submit]');
		celuila.hide();

		$(this).find('.loader').show();

		bs_description = $('#bs_description').val();
		bs_experience = $('#bs_experience').val();
		edit_type = 'description';

		$.post('inc/profilbs.inc.php', {
			bs_description: bs_description,
			bs_experience: bs_experience,
			edit_type: edit_type
		}, function(data){
			console.log(data);
			if (data !='ok') {
				$.each(data, function(key, val) {
					$('p.erreurs[data-erreurs='+key+']').text(val).slideDown();
				});
				pValid = '<p class="erreur">Il y a des erreurs</p>';
				function divers(){};
				jacqueline(1000, pValid, celuila, divers);
			} else if(data == "ok") {
				console.log(data);
				pValid = '<p class="valid">Votre profil a été mis jour !</p>';
				function divers(){};
				jacqueline(1000, pValid, celuila, divers);
			}
		}, "json");
	});

	// BABYSITTER INFOS BABYSITTINGS
	$('.edit-blocs .bs_babysittings').submit(function(e) {
		e.preventDefault();

		celuila = $(this).find('input[type=submit]');
		celuila.hide();

		$(this).find('.loader').show();

		new_born = 1;
		if($('div.new_born input').is(':checked')){new_born = 2;}
		age_debut = $('#age_debut').val();
		age_fin = $('#age_fin').val();
		prix_bs = $('#prix_bs').val();


		edit_type = 'babysittings';
		console.log(new_born);
		console.log(edit_type);

		$.post('inc/profilbs.inc.php', {
			age_debut: age_debut,
			age_fin: age_fin,
			new_born: new_born,
			prix_bs: prix_bs,
			edit_type: edit_type
		}, function(data){
			console.log(data);
			if (data !='ok') {
				$.each(data, function(key, val) {
					$('p.erreurs[data-erreurs='+key+']').text(val).slideDown();
				});
				pValid = '<p class="erreur">Il y a des erreurs</p>';
				function divers(){};
				jacqueline(1000, pValid, celuila, divers);
			} else if(data == "ok") {
				console.log(data);
				pValid = '<p class="valid">Votre profil a été mis jour !</p>';
				function divers(){};
				jacqueline(1000, pValid, celuila, divers);
			}
		}, "json");
	});


	// DISPONIBILITÉS
	$('#form_dispos').on('submit', '.becomeFree', function(e) {
		e.preventDefault();

		celuila = $(this).find('input[type=submit]');
		celuila.hide();

		$(this).find('.loader').show();

		heure_debut_dispo = $('.becomeFree #heure_debut_dispo').val();
		min_debut_dispo = $('.becomeFree #min_debut_dispo').val();
		heure_fin_dispo = $('.becomeFree #heure_fin_dispo').val();
		min_fin_dispo = $('.becomeFree #min_fin_dispo').val();
		year_dispo = $('.calendar .generate-calendar .year').text();

		dates = [];
		jours = [];
		month = $(".month:visible").attr('id');
		$('.calendar-form #form_dispos ul.date li').each(function() {
			dates.push($.trim($(this).text()));
			jours.push($(this).text().replace(/\D+/g,''));
		});

		$.post('inc/savedispos.inc.php', {
			dates: dates,
			heure_debut_dispo: heure_debut_dispo,
			min_debut_dispo: min_debut_dispo,
			heure_fin_dispo: heure_fin_dispo,
			min_fin_dispo: min_fin_dispo,
			year_dispo: year_dispo

		}, function(data){
			if (data !='ok') {
				$.each(data, function(key, val) {
					$('p.erreurs[data-erreurs='+key+']').text(val).slideDown();
				});
				pValid = '<p class="erreur">Il y a des erreurs</p>';
				function divers(){};
				jacqueline(1000, pValid, celuila, divers);
			} else if(data == "ok") {
				$.each( jours, function( i, val ) {
					$(".relative").contents("div.dateSelect:contains('"+val+"')").addClass('free');
					$("#"+month+" .relative").contents("div.dateSelect:contains('"+val+"')").closest('td').find('ul.events').append("<li class='dispo day"+val+"'>"+heure_debut_dispo+":"+min_debut_dispo+"</li><li class='dispo day"+val+"'>"+heure_fin_dispo+":"+min_fin_dispo+"</li><li class='dispo delete'><a href='#'><i class='fa'></i></a></li>");
					$("#"+month+" .relative").contents("div.dateSelect:contains('"+val+"')").closest('td').find('ul.events').css('border-color', '#a6d132');
					$(".relative").contents("div.dateSelect:contains('"+val+"')").removeClass('dateSelect');
				});


				pValid = '<p class="valid">Votre profil a été mis jour !</p>';
				function divers(){};
				jacqueline(1000, pValid, celuila, divers);

				$('.dateSelect').parents('td').find('ul.events').css('border-color', '#a6d132');
				$('.dateSelect').removeClass('dateSelect');
				date = $('.month td.today').children('.daytitle').text();
				date = $.trim(date);
				$('.calendar-form .date').html('<li>'+date+'</li>');

				setTimeout(function(){
					console.log('coucou');
					$('.calendar-form form.becomeFree').fadeOut('400', function() {
						text = $('.today ul.events').html();
						text = $.trim(text);
						$('.calendar-form .day-details').html(text);
					});
				}, 2000);
			}
		}, "json");
	});

	// SUPPRIMER DISPONIBILITÉS
	$('.calendar-form').on('click', 'li.delete', function(e) {
		e.preventDefault();
		celuila = $(this);

		heures = [];
		$(this).parents('.day-details').find('li.dispo').each(function() {
			heures.push($(this).text());
		});
		console.log(heures);
		heure_debut = heures[0];
		heure_fin = heures[1];

		var heure_debut = heures[0].split(":");
		min_debut = heure_debut[0];
		heure_debut = heure_debut[1];

		var heure_fin = heures[1].split(":");
		min_fin = heure_fin[0];
		heure_fin = heure_fin[1];


		date = $.trim($('#form_dispos ul.date').text());
		year = $('.calendar .generate-calendar .year').text();

		date = date.split(" ");
		day = date[1];
		month = date[2];

		$.post('inc/deletedispos.inc.php', {
			date: date,
			day: day,
			month: month,
			year: year
		}, function(data){
			console.log(data);
			if (data !='ok') {
			} else if(data == "ok") {
				$('.day-details').find('.dispo').fadeOut('400', function() {
					$(this).parents('.day-details').find('.dispo').remove();
				});

				$(".month:visible .relative").contents("div.free").each(function() {
					content = $(this).text();
					if (content == day) {
						$(this).removeClass('free');
						list = $(this).closest('td').find('ul.events');
						list.css('border-color', '#d9d9d9');

					};
				});

				setTimeout(function(){
						$('.day-details').append('<li><p class="valid" style="display: none">Votre date a été supprimée</p></li>');
						$('.day-details li p.valid').fadeIn();
				}, 400);
				setTimeout(function(){
						$('.day-details li p.valid').fadeOut();
				}, 2000);
				list.text('');


			}
		}, "json");




	});




});