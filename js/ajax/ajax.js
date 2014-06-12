$(document).ready(function() {
	
	// INSCRIPTION
	$('#inscription form').submit(function(e){
		e.preventDefault();
		register_name = $('#register_name').val();
		register_firstname = $('#register_firstname').val();
		register_email = $('#register_email').val();
		register_password = $('#register_password').val();
		register_account_type = $('.register_account_type:checked').val();

		$('p.erreurs').slideUp();

		$.post('inc/signin.inc.php', {register_firstname: register_firstname, register_name: register_name, register_email: register_email, register_password: register_password, register_account_type :register_account_type}, function(data){
			if (data !='ok') {
				$.each(data['erreurs'], function(key, val) {
					$('p.erreurs[data-erreurs='+key+']').text(val).slideDown();
				});
			} else {
				path = window.location.pathname;
				window.location.href='index.php';
			}
		}, "json");
	});

	// CONNEXION
	$('#connexion form').submit(function(e){
		e.preventDefault();
		login_email = $('#login_email').val();
		login_password = $('#login_password').val();

		$('p.erreurs').slideUp();

		$.post('inc/login.inc.php', {login_email: login_email, login_password: login_password}, function(data){
			if (data !='ok') {
				$.each(data['erreurs'], function(key, val) {
					$('p.erreurs[data-erreurs='+key+']').text(val).slideDown();
				});
			} else {
				path = window.location.pathname;
				window.location.href='index.php';
			}
		}, "json");
	});
});