$(document).ready(function() {
	// RÉPONDRE DEMANDE
		$('.answerComment').on('submit', '.comParent', function(e) {
			e.preventDefault();

			console.log($(this));
			celuila = $(this);

			e.preventDefault();

			commentaire = $(this).find('#message').val();
			idBabysitting = $(this).closest('li').attr('data-babysitting');
			babysitterId = $(this).closest('li').attr('data-babysitterid');
			postType = 'commentaire';

			$.post('inc/commentaires.inc.php', {
				commentaire: commentaire,
				idBabysitting: idBabysitting,
				babysitterId: babysitterId,
				postType: postType
			}, function(data){
				console.log(data.status);
				if(data.status == 'ok') {
					celuila.find('label').slideUp();
					celuila.find('textarea').attr('disabled', true).css({
						'background': '#f0f0f0',
						'color': '#17181f'
					});
					celuila.find('input, a').slideUp();
					celuila.closest('li').find('i.comment b').addClass('complete');
				}
			}, "json");
		});

	// NOTE
		$('.parent .like.noter').on('click', 'b', function(e) {
			e.preventDefault();


			celuila = $(this);

			e.preventDefault();

			idBabysitting = $(this).closest('li').attr('data-babysitting');
			babysitterId = $(this).closest('li').attr('data-babysitterid');
			postType = 'note';
			note = $(this).attr('data-note');

			console.log(celuila);

			$.post('inc/commentaires.inc.php', {
				note: note,
				postType: postType,
				babysitterId: babysitterId,
				idBabysitting: idBabysitting
			}, function(data){
				console.log(data.status);
				if(data.status == 'ok') {
					celuila.closest('.like').removeClass('noter');
				}
			}, "json");
		});

	// FAVORIS
		$('.parent .fav').on('click', 'b', function(e) {
			e.preventDefault();

			celuila = $(this);

			e.preventDefault();

			idBabysitting = $(this).closest('li').attr('data-babysitting');
			babysitterId = $(this).closest('li').attr('data-babysitterid');
			postType = 'favoris';
			fav = $(this).attr('data-fav');

			if (fav == 0) {
				fav = 1;
			}else if(fav == 1){
				fav = 0;
			}


			console.log(fav);

			$.post('inc/commentaires.inc.php', {
				fav: fav,
				postType: postType,
				babysitterId: babysitterId,
				idBabysitting: idBabysitting
			}, function(data){
				console.log(data.status);
				if(data.status == 'ok') {
					console.log(fav);
					celuila.attr('data-fav', fav);
				}
			}, "json");
		});
});


