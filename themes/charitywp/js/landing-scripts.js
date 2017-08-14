$(document).ready(function(){
	console.log('landing scripts');

	var the_fader = $('figcaption.caption_interactive');
	the_fader.hide();
	$('figure.retrato_artista').on('mouseenter', function(){
		$(this).find(the_fader).fadeIn('slow');
	});
	$('figure.retrato_artista').on('mouseleave', function(){
		$(this).find(the_fader).fadeOut('slow');
	});
});//end document