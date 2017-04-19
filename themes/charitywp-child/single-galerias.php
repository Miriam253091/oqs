<?php get_header(); 

	if(have_posts()):
	?>
		<section class="image_pool">
		<?php	
			while(have_posts()):
				the_post();
			?>
				<div class="col-md-12">
					<?php the_title(); ?>
				</div>
				<div class="col-md-12 img_container">
					<?php the_content(); ?>
				</div>
					<?php
			endwhile;
			?>
		</section>
<?php
	endif;		
	?>

<?php get_footer(); ?>