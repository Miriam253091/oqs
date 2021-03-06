<?php
/**
 * cart item
 */
$cart_contents = donate()->cart->cart_contents;

?>

<tbody>
	<?php foreach( $cart_contents as $cart_item_key => $cart_content ): ?>

		<tr>
			<td class="donate_action_remove">
				<!--remove-->
				<a href="<?php echo esc_attr( donate_cart_url() . '?donate_remove_item=' . $cart_item_key ) ?>" id="<?php echo esc_attr( $cart_item_key ) ?>">X</a>
			</td>
			<td class="donate_cart_item_name">
				<!--thumbnail-->
				<div class="donate_cart_item_thumbnail">
					<?php echo get_the_post_thumbnail( $cart_content->product_id, 'thumbnail', array( 'width' => 100, 'height' => 100 ) ); ?>
				</div>
				<!--title-->
				<div class="donate_cart_item_name_title">
					<a href="<?php echo esc_attr( get_permalink( $cart_content->product_id ) ) ?>"><?php printf( '%s', $cart_content->product_data->post_title ) ?></a>
				</div>
			</td>
			<td class="donate_cart_item_amount"><?php printf( '%s', donate_price( $cart_content->amount, donate_get_currency() ) ) ?></td>
		</tr>

	<?php endforeach; ?>
</tbody>