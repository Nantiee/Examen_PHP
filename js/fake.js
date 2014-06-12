$(document).ready(function() {
	// icones

		$('div.details.parent i.fav b').click(function() {
			if($(this).hasClass('complete')){
				$(this).removeClass('complete').text('');
			}else{
				$(this).addClass('complete').text('');
			}
		});
		$('div.details.parent').on('mouseover', 'i.noter b', function() {
			$(this).css('color', '#ff4b4b');
			$(this).prevAll('b').css('color', '#ff4b4b');
			$(this).nextAll('b').css('color', '#d9d9d9');
		});
		$('div.details.parent i.like.noter b').click(function() {
			$(this).prevAll().addClass('complete').text('');
			$(this).nextAll().removeClass('complete').text('');

			$(this).addClass('complete').text('');
		});
		$('.vide').click(function(e) {
			e.preventDefault();
			return false;
		});






	// DEMANDES
		$('.message a.valider').click(function() {
			$(this).css('background', '#a6d132');
		});
		$('.message a.refuser').click(function() {
			$(this).css('background', '#ff2821');
		});
		$('.message a.valider, .message a.refuser').click(function(e) {
			e.preventDefault();
			$(this).siblings('a').fadeOut(150, function(){
				$(this).siblings('a').animate({
					width: '100%'},
					500, function() {
				});
				$(this).parents('li').find('.demandeReponse').slideDown();
			});
		});

		$('.demandeReponse form a.annuler').click(function(e) {
			$('.message a.refuser').css('background', '#ff7c78');
			$('.message a.valider').css('background', '#c5e179').fadeIn();
			e.preventDefault();
			console.log('annuler');
			$(this).parents('.demandeReponse').slideUp();
			$('.message a').animate({
				width: 'auto'},
				500, function() {
			});

		});
});













