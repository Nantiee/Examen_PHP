$(document).ready(function() {
	$( "#datepicker" ).datepicker({
		minDate: 0,
		onSelect: function() {
            $('#header-search input#datepicker').addClass('complete');
        }
	});
// ***** A DECOMMENTER
	$("#geocomplete").geocomplete().bind("geocode:result", function(event, result){
		$.log("Result: " + result.formatted_address);
	}).bind("geocode:error", function(event, status){
		$.log("ERROR: " + status);
	}).bind("geocode:multiple", function(event, results){
		$.log("Multiple: " + results.length + " results found");
	});

	$('#heure_debut_dispo, #min_debut_dispo, #heure_fin_dispo, #min_fin_dispo, #geocomplete').blur(function () {
	    var self = $(this);
	    if (self.val() != "") {
	        self.addClass('complete');
	    } else {
	        self.removeClass('complete');
	    }
	});
// ***********

// RECHERCHE

	$('#header-search .form-search input[type=checkbox]').click(function(e) {
		child = $(this).val();
		$('label[for='+child+']').toggleClass('select');
		$('label[for='+child+']').toggleClass('noselect');
		$('label[for='+child+'] span').fadeToggle('100', function() {
		});
		$('label[for='+child+'].noselect').animate({padding: '12px 24px'}, 200);
		$('label[for='+child+'].select').animate({padding: '12px 24px 12px 36px'}, 100);
	});


	$('#header-search .form-search input[type=submit]').click(function(e) {
		e.preventDefault();

		recherche = [];
		children = [];
		births = [];

		$('input[type=checkbox]:checked').each(function() {
			children.push($(this).val());
			births.push($(this).attr('data-birth'));
		});

		console.log(children);
		console.log(births);

		date = $('#datepicker').val();
		heure_debut_dispo = $('#heure_debut_dispo').val();
		min_debut_dispo = $('#min_debut_dispo').val();
		heure_fin_dispo = $('#heure_fin_dispo').val();
		min_fin_dispo = $('#min_fin_dispo').val();
		lieu = $('#geocomplete').val();

		recherche.push(children, date, heure_debut_dispo, min_debut_dispo, heure_fin_dispo, min_fin_dispo, lieu, births);

		$.post('inc/searchdispos.inc.php', {
			date: date,
			heure_debut_dispo: heure_debut_dispo,
			min_debut_dispo: min_debut_dispo,
			heure_fin_dispo: heure_fin_dispo,
			min_fin_dispo: min_fin_dispo,
			children: children,
			births: births,
			lieu: lieu
		}, function(data){
			if (typeof data.babysitterId === 'undefined'){
				data.babysitterId = '';
				$("#content #result").load("inc/babysitters.inc.php", { // N'oubliez pas l'ouverture des accolades !
				    babysitters : data.babysitterId,
				    recherche: recherche
				});

			}else if(data.status == 'ok') {
				$("#content #result").load("inc/babysitters.inc.php", { // N'oubliez pas l'ouverture des accolades !
				    babysitters : data.babysitterId,
				    recherche: recherche
				});
			}
		}, "json");
	});
});
