<?php get_header(); 

	if(have_posts()):
	?>
		<section class="image_pool">
		<?php	
			while(have_posts()):
				the_post();

				$content = get_the_content();
				// $content = explode($content);
				$content = preg_replace("/[^0-9,.]/", "", $content);
				$content = explode(',', $content);
			?>
				<div class="col-md-12">
					<?php the_title(); ?>
				</div>

		<?php		
				foreach ($content as $img_id) {
					?>
					<div class="col-md-4 img_container">
						<?php echo wp_get_attachment_image($img_id, 'large')."<br>"; ?>
					</div>

					<?php
				}

			endwhile;
			?>
		</section>
<?php
	endif;		
	?>

<?php get_footer(); ?>