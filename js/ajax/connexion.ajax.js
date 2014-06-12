$(document).ready(function() {

	// INSCRIPTION

	$('#inscription form input[type=submit]').click(function(e){
		e.preventDefault();
		register_name = $('#register_name').val();
		register_firstname = $('#register_firstname').val();
		register_email = $('#register_email').val();
		register_password = $('#register_password').val();
		register_account_type = $('.register_account_type:checked').val();
		register_user_type = $('.register_user_type:checked').val();

		if (typeof register_user_type === 'undefined') {
			register_user_type = 3;
		};

		console.log(register_user_type);

		$('p.erreurs').slideUp();

		$.post('inc/signin.inc.php', {register_firstname: register_firstname, register_name: register_name, register_email: register_email, register_password: register_password, register_account_type :register_account_type, register_user_type :register_user_type}, function(data){
			if (data !='ok') {
				$.each(data, function(key, val) {
					$('p.erreurs[data-erreurs='+key+']').text(val).slideDown();
				});
			} else {
				console.log('ok');
				window.location.href='index.php';
			}
		}, "json");
	});

	// CONNEXION
	$('#connexion form input[type=submit]').click(function(e){
		e.preventDefault();
		console.log('login');
		login_email = $('#login_email').val();
		login_password = $('#login_password').val();

		$('p.erreurs').slideUp();

		$.post('inc/login.inc.php', {login_email: login_email, login_password: login_password}, function(data){
			if (data !='ok') {
				$.each(data['erreurs'], function(key, val) {
					$('p.erreurs[data-erreurs='+key+']').text(val).slideDown();
				});
			} else {
				window.location.href='index.php';
			}
		}, "json");
	});
});