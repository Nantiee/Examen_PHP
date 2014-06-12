$(document).ready(function() {

// RECHERCHE
	$('#result').on('submit', '.bonusdemande .message .send_demande', function(e) {
		e.preventDefault();

		celuila = $(this);

		$(this).find('input[type=submit]').slideUp();

		date = $('#datepicker').val();
		date = $.trim($('#datepicker').val());
		if (date != '') {

			children = [];
			childid = [];
			births = [];
			recherche = [];
			infos = 'coucou';
			$('.icheckbox_line-main.checked').each(function() {
				children.push($(this).find('input').val());
				births.push($(this).find('input').attr('data-birth'));
				childid.push($(this).find('input').attr('data-childid'));
			});

			heure_debut_dispo = $('#heure_debut_dispo').val();
			min_debut_dispo = $('#min_debut_dispo').val();
			heure_fin_dispo = $('#heure_fin_dispo').val();
			min_fin_dispo = $('#min_fin_dispo').val();
			lieu = $('#geocomplete').val();
			phone = $(this).parents('.bonusdemande').find('ul.infos_demande li.telephone span').text();

			babysitterId = $(this).parents('.bonusdemande').attr('data-babysitter');
			date_demande = $(this).parents('.bonusdemande').find('.date').attr('data-date');
			enfants = $(this).parents('.bonusdemande').find('ul.infos_demande li.enfants span').text();

			recherche.push(children, date, heure_debut_dispo, min_debut_dispo, heure_fin_dispo, min_fin_dispo, lieu, phone, babysitterId, childid, date_demande, enfants);
		}else{
			infos = [];
			recherche = 'notfound';
			babysitterId = $(this).parents('.bonusdemande').attr('data-babysitter');
			infos.push(babysitterId);
		}

		message =  $(this).find('textarea#message').val();

		$.post('inc/demandes.inc.php', {
			recherche: recherche,
			infos: infos,
			message: message,
		}, function(data){
			console.log(data);
			if(data.status == 'ok') {
				label = celuila.find('label');
				reponse = label.text().replace('Ajouter un', 'Votre');
				celuila.closest('li').find('button').text('Votre demande a été envoyée').css('background', '#a6d132');
				celuila.find('textarea').attr('disabled', true);
				setTimeout(function(){
					celuila.closest('.bonusdemande').slideUp();
				}, 400);
				setTimeout(function(){
					label.text(reponse);
				}, 800);

			}
		}, "json");
	});


	// RÉPONDRE DEMANDE
		$('.demande').on('submit', '.demandeReponse', function(e) {
			e.preventDefault();

			celuila = $(this);

			reponse_demande = $(this).closest('li').find('div.message a:visible').attr('class');
			message_reponse = $(this).find('#message').val();
			demande_id = $(this).closest('li').attr('data-demandeid');

			$.post('inc/reponsedemande.inc.php', {
				reponse_demande: reponse_demande,
				message_reponse: message_reponse,
				demande_id: demande_id
			}, function(data){
				console.log(data.status);
				if(data.status == 'ok') {
					reponse = celuila.find('label').text().replace('Répondre', 'Réponse');
					celuila.find('label').text(reponse);
					celuila.find('textarea').attr('disabled', true);
					celuila.find('input, a').slideUp();
					celuila.closest('li').find('.message a.refuser').text('Refusé');
					celuila.closest('li').find('.message a.valider').text('Accepté');
				}
			}, "json");
		});

	// ANNULER DEMANDE
		$('.demande .message').on('click', '.delete-demande', function(e) {
			e.preventDefault();

			console.log($(this));
			celuila = $(this);

			console.log('annuler demande')

			demande_id = $(this).closest('li').attr('data-demande');
			console.log(demande_id);

			$.post('inc/deletedemande.inc.php', {
				demande_id: demande_id
			}, function(data){
				console.log(data);
				if(data == 'ok') {
					celuila.text('Demande annulée');
					celuila.animate({
						width: '100%',
						background: '#ff2821'

					},500);
					setTimeout(function(){
						celuila.closest('li').slideUp();
					}, 1000);
				}
			}, "json");
		});
});


