<?php get_header();
	$args = array(
			'post_type'=>'galerias',
			'posts_per_page'=>-1,
			'post_status'=>'publish'
		);
	$posts = new WP_Query($args);
	if($posts->have_posts()):
	?>
</div>
	<?php
		while($posts->have_posts()):
			$posts->the_post();
	?>
			<archive class="gallery_archive_post">
			<a href="<?php the_permalink(); ?>">
				<h2><?php the_title(); ?></h2>
			</a>
			<div>
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('large'); ?>
				</a>
			</div>
			</archive>
	<?php
		endwhile;
	echo "</div>";	
	endif;
?>
<?php get_footer(); ?>