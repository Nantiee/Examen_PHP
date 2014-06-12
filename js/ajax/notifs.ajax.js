$(document).ready(function() {
	// NOTIFICATIONS

		// var notifications = function(){
		// 	console.log('notifs');

		// 	$.get( "inc/notifications.inc.php", function() {
		// 	  alert( "Load was performed." );
		// 	});


		// }




		var notifications = function notifications() {
			$('ul#notifications').html('');
			$('ul#notifications').append('<li class="no-notif">Vous n\'avez pas de nouvelle notification.</li>');
			$('#header nav ul li a.button-notif i.notifications').html('');
			$('#header nav ul li a.button-notif i.notifications').css('display', 'none');
			$('#sidebar nav ul li.side_demandes a b').text('');

			$.get( "inc/notifications.inc.php", function(data) {
				$('ul#notifications').html('');
				i = 0;
				for (var i = 0; i < data.length; i++) {

				if (data[i]['notif_type'] == 1 ) {
					message = data[i]['parent']+" vous a envoyé une demande.";
					liclass = '';
				};
				if (data[i]['notif_type'] == 2 ) {
					message = data[i]['babysitter']+" a <b>accepté</b> votre demande";
					liclass = "accepted";
				};
				if (data[i]['notif_type'] == 3 ) {
					message = data[i]['babysitter']+" a <b>refusé</b> votre demande";
					liclass = "refused";
				};
				notif ='<li class="'+liclass+'"><a href="demandes.php"><img src="img/'+data[i]['photo']+'" alt=""><p>'+message+'</p></a></li>';
				console.log(notif);
				$('ul#notifications').append(notif);

			};

			$('#header nav ul li a.button-notif i.notifications').html(data.length);
			$('#header nav ul li a.button-notif i.notifications').css('display', 'block');
			$('#sidebar nav ul li.side_demandes a b').text('('+data.length+')');


			}, "json");
		}
		notifications();
		var interval = 1000 * 30; // 5sec
		setInterval(notifications, interval);

	// Valid notif vu
	$('#header nav ul li a.button-notif').click(function(e) {
		e.preventDefault();
		celuila = $(this);

		vue_notif = 2;
	$.post('inc/vunotifications.inc.php', {
			vue_notif: vue_notif
		}, function(data){
			console.log(data.status);
			if(data.status == 'ok') {
				console.log(fav);
				celuila.attr('data-fav', fav);
			}
		}, "json");
	});




});



