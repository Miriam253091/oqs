<?php
/**
 * Template Name: Home Page
 *
 **/
get_header();?>

	<div class="home-page container site-content">
		<div class="club_premier">
			<p style="color:white;">#ExperienciasPremier</p>
			<img src="<?php echo get_template_directory_uri(); ?>/images/logo_ae_premiere.svg">
			<ul class="ul_premier">
				<li>
					<a target="_blank" href="https://www.clubpremier.com/mx/utiliza/comparte-puntos-premier/instituciones-y-causas/ojos-que-sienten/">Si eres Socio Club Premier, ahora puedes ayudar a OQS usando tus puntos premia.</a>				
				</li>
				<li>
					<a target="_blank" href="http://experiencias.clubpremier.com/es/experiencias/detalle/464">Utiliza tus Puntos Premier y activa tus sentidos en una Cena en la Obscuridad® especial para socios Club Premier.</a>
				</li>
			</ul>
		</div>
		<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();
			the_content();
		endwhile;
		?>
	</div><!-- #main-content -->
<?php get_footer();
