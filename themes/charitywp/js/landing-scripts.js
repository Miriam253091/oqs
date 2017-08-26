$(document).ready(function(){
	console.log('landing scripts');

	var the_fader = $('figcaption.caption_interactive');
	if($(window).width() > 768){
		the_fader.hide();
	}
	$('figure.retrato_artista').on('mouseenter', function(){
		$(this).find(the_fader).fadeIn('slow');
	});
	$('figure.retrato_artista').on('mouseleave', function(){
		$(this).find(the_fader).fadeOut('slow');
	});


	/*
	 * TABS PERFILES PATROCINADORES & VIP
	*/

	$('.plegable, .fa-angle-up').hide();
	$('.clickable').on('click', function(){
		$(this).find('.fa-angle-up').toggle('fast');
		$(this).find('.fa-angle-down').toggle('fast');
		$(this).find('.plegable').slideToggle(800);
	});

	$('.overscreen').hide();
	$('.lan_menu_show').on('click', function(){
		console.log('click');
		$('.overscreen').toggle('slide');
	});


});//end document