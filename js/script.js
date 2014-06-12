// @codekit-prepend '../bower_components/jquery/dist/jquery.min.js';

// Typekit //

	(function(d) {
	var config = {
		kitId: 'dud3ugq',
		scriptTimeout: 3000
	},
	h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
	})(document);


// INSTANCLICK //




// CHECKBOX //

$(document).ready(function(){
	// $('#header-search input').each(function(){
	// 	var self = $(this),
	// 		label = self.next(),
	// 		label_text = label.text();

	// 	label.remove();
	// 	self.iCheck({
	// 		checkboxClass: 'icheckbox_line-main',
	// 		radioClass: 'iradio_line-main',
	// 		insert: '<div class="icheck_line-icon"></div>' + label_text
	// 	});
	// });



// ICONES COMMENT FAV LIKE //

	$('i.fa b').click(function() {
		if ($('i.fa b').hasClass("uncomplete")){
			$( this ).toggleClass( "uncomplete" );

		} else if ($('i.fa b').hasClass("complete")) {

		}
	});


// TROUVER UN BABYSITTER //

	$('#header-button-search').click(function() {
		if ($('#header-search').is(":hidden")) {
			$('#header-button-search').css('width', '387px');
			$('#header-search').fadeIn(200);
			$('#content').css({
				transform: 'translate(0,200px)'
			});
		} else {
			$('#header-button-search').css('width', '92px');
			$('#header-search').slideUp(100);
			$('#content').css({
				transform: 'translate(0,0px)'
			});
		}
	});

	croissant = true;
	$('body').on('click', '.selector', function() {
		if (croissant == true) {
			$(this).css({
				transform: 'rotate(180deg)'
			});
			croissant = false;
		}else{
			$(this).css({
				transform: 'rotate(0deg)'
			});
			croissant = true;
		};

	});
	$('body').on('click', '.button-notif', function() {
		$('#notifications').fadeToggle(200);
	});
	$('body').on('click', 'i.comment', function() {
		$(this).parents('li').children('div.bonuscomment').slideToggle();
	});
	$('body').on('click', '.infos button', function() {
		$(this).parents('li').children('div.bonusdemande').slideToggle();
	});


// INSCRIPTION
	$('#landing .col-6 a').click(function() {

		if($(this).closest("div").hasClass('parent')) {
			$('#landing .col-12>.col-6').fadeOut(150,function(){
				$("#inscription").fadeIn();
				$('#inscription .gender').css('display','none');
				$('#inscription .select #parent').attr('checked',true);
			});
		}else if($(this).closest("div").hasClass('babysitter')) {
			$('#landing .col-12>.col-6').fadeOut(150,function(){
				$("#inscription").fadeIn();
				$('#inscription .select #babysitter').attr('checked',true);
			});
		}

	});
	$('#landing #inscription .select label[for=parent]').click(function() {
		$('#inscription .gender').css('display','none');
	});
	$('#landing #inscription .select label[for=babysitter]').click(function() {
		$('#inscription .gender').css('display','block');
	});
	$('#landing #inscription .radio label').click(function() {
		$(this).closest('.select').find('input').attr('checked', false);
		// $('#landing #inscription .radio input').attr('checked', false);
		console.log('radius');
		$(this).find('input').attr('checked', true);
	});
	$('#connexion a').click(function() {
		$('#connexion').fadeToggle(150,function(){
			$('p.erreurs').slideUp();
			$('#inscription').fadeToggle();
		});
	});
	$('.connexionButton').click(function() {
		$('#inscription').slideUp();
		$('.parent').slideUp();
		$('.parent').slideUp();
		$('.babysitter').slideUp();
		$('#connexion').fadeToggle();
	});
	$('#inscription a').click(function() {
		$('p.erreurs').slideUp();
		$('#inscription').fadeToggle(150,function(){
			$('#connexion').fadeToggle();
		});
	});



// PROFIL
	$('a.edit-profil').click(function() {
		console.log('edit');
		$(this).css('display', 'none');
		$('a.valid-profil').css('display', 'block');
		$(".profil ul li input").removeAttr( "disabled");
	});

	$('a.valid-profil').click(function() {
		console.log('edit');
		$(this).css('display', 'none');
		$('a.edit-profil').css('display', 'block');
		$(".profil ul li input").prop('disabled', true);
	});


	// ADD CHILD

	$('.edit-blocs #add-child').click(function() {
		$(this).css('display', 'none');
		$('.edit-blocs #add-child+div.child').slideDown();

	});

	$('#child_birth .number').autotab({ format: 'number' });
	$('#child_birth #number3').autotab('disable');

// NEXT/LAST BABYSITTINGS

	$('#next .babysitting-tabs li').click(function() {
		selectedList = $(this).attr('class').replace('bs-tab', '').replace('active-tab', '').trim();
		console.log(selectedList);
		$('.babysittingList').hide();
		$('ul.'+selectedList).show();
		$('#next .bs-tab').removeClass('active-tab');
		$(this).addClass('active-tab');
	});

	$('form.becomeFree select').change(function () {
		var self = $(this);
		if (self.val() != "") {
		    self.addClass('complete');
		} else {
		    self.removeClass('complete');
		}
	});


});
