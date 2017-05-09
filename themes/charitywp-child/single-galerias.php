<?php get_header(); ?>
		<section class="image_pool">
		<?php			
			if(have_posts()):
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
			endif;		
		?>
		</section>
	</div>
</div>
<?php get_footer(); ?>