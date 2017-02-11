<?php if ( $instance['title'] <> '' ) {
	echo '<h3 class="widget-title">' . esc_attr( $instance['title'] ) . '</h3>';
} ?>
<div class="kcf-module">
 	<div
		class="ob-google-map-canvas"
		style="height:<?php echo intval( $height ) ?>px;"
		id="ob-map-canvas-<?php echo esc_attr( $map_id ) ?>"
		<?php foreach ( $map_data as $key => $val ) : ?>
			<?php if ( !empty( $val ) ) : ?>
				data-<?php echo esc_attr($key) . '="' . esc_attr( $val ) . '"' ?>
			<?php endif ?>
		<?php endforeach; ?>
		>
	</div>
	<div class="overlay">
		<?php if (isset($map_data['marker-icon']) && $map_data['marker-icon'] != '') : ?>
			<img src="<?php echo esc_url($map_data['marker-icon']); ?>" alt="">
		<?php endif; ?>
	</div>
</div>