<?php
	/**
	 * The Header for our theme.
	 *
	 * Displays all of the <head> section and everything up till <div id="content">
	 *
	 * @package thim
	 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>">

	<?php wp_head(); ?>
	
	<!-- Igni Scripts-->
	<script src="http://reservacion.ojosquesienten.org/site/js/jquery.validate.min.js"></script>
    <script src="http://www.ojosquesienten.com/js/init.js"></script>
    <!-- Engage Web Tracking Code -->

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-91771961-3', 'auto');
      ga('send', 'pageview');

    </script>
<!-- Silverpoop Tracking -->
<meta name="com.silverpop.brandeddomains" content="www.pages05.net,dev.goigni.com,goigni.com,goigni.net,ignisa.mkt4247.com,ojosquesienten.com,pages05.net" />
<script src="http://contentz.mkt51.net/lp/static/js/iMAWebCookie.js?572b8dd-132cb581cc5-c6f842ded9e6d11c5ffebd715e129037&h=www.pages05.net" type="text/javascript"></script>
</head>
<body <?php body_class(); ?>>
	<!--aqui empieza body-->
	<?php do_action('thim_loading'); ?>
	
	<?php //get_template_part( 'inc/header/main-menu' ); ?>
	
	<div id="wrapper-container" class="wrapper-container">
		<div class="content-pusher <?php thim_site_layout() ?>">
				<?php if ( !(is_page() && basename(get_page_template()) == 'comingsoon.php') ) : ?>
					<?php do_action('thim_header_toolbar'); ?>
					<?php do_action('thim_header_site'); ?>
				<?php endif; ?>
				<div id="main-content">



					