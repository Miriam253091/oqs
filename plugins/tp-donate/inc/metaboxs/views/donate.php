<?php $cart_contents = $this->get_field_value( 'cart_contents' ); ?>
<?php global $post; ?>
<?php $donation = DN_Donate::instance( $post->ID ) ?>

<?php if( $cart_contents ): ?>
	<table>
		<thead>
			<tr>
				<th><?php _e( 'Campaign ID', 'tp-donate' ); ?></th>
				<th><?php _e( 'Campaign Title', 'tp-donate' ); ?></th>
				<th><?php _e( 'Compensate', 'tp-donate' ); ?></th>
				<th><?php _e( 'Donation amount', 'tp-donate' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php $currency = donate_get_currency(); ?>
			<?php foreach( $cart_contents as $cart_item_key => $cart_content ) : ?>
				<tr>
					<td>
						<a href="<?php echo get_edit_post_link( $cart_content->product_id  ) ?>"><?php printf( '%s', donate_generate_post_key( $cart_content->product_id ) ) ?></a>
					</td>
					<td>
						<?php printf( '%s', get_the_title( $cart_content->product_id ) ) ?>
					</td>
					<td>
						<?php echo donate_find_compensate_by_amount( $cart_content->product_id, $cart_content->amount ); ?>
					</td>
					<td>
						<?php $currency = $cart_content->currency; ?>
						<?php printf( '%s', donate_price( $cart_content->amount, $cart_content->currency ) ) ?>
					</td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td><?php _e( 'Addition note', 'tp-donate' ); ?></td>
				<td colspan="3">
					<?php global $post; $donate_id = $post->ID ?>
					<?php $donation = DN_Donate::instance( $donate_id ); ?>
					<?php printf( '%s', $donation->get_meta( 'addition' ) ) ?>
				</td>
			</tr>
			<tr>
				<td colspan="3"><?php _e( 'Total amount', 'tp-donate' ); ?></td>
				<td>
					<?php global $post; $donate_id = $post->ID ?>
					<?php $donation = DN_Donate::instance( $donate_id ) ?>
					<?php printf( '%s', donate_price( $donation->get_meta( 'total' ), $currency ) ) ?>
				</td>
			</tr>
			<tr>
				<td colspan="3"><?php _e( 'Donor', 'tp-donate' ); ?></td>
				<td>
					<?php $donor_id = $this->get_field_value( 'donor_id' ); ?>
					<a href="<?php echo get_edit_post_link( $donor_id ) ?>">
						<?php $donor = DN_Donor::instance( $donor_id ); ?>
						<?php printf( '%s %s', $donor->get_meta( 'first_name' ), $donor->get_meta( 'last_name' ) ) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>

<?php elseif ( $donation->get_meta( 'amount_system' ) ) : ?>

	<table>
		<tbody>
			<tr>
				<th>
					<?php _e( 'Donate for system', 'tp-donate' ); ?>
				</th>
				<td>
					<?php echo donate_price( $donation->get_meta( 'total' ), $donation->get_meta( 'currency' ) ) ?>
				</td>
			</tr>
			<tr>
				<td><?php _e( 'Donor', 'tp-donate' ); ?></td>
				<td>
					<?php $donor_id = $this->get_field_value( 'donor_id' ); ?>
					<a href="<?php echo get_edit_post_link( $donor_id ) ?>">
						<?php $donor = DN_Donor::instance( $donor_id ); ?>
						<?php printf( '%s %s', $donor->get_meta( 'first_name' ), $donor->get_meta( 'last_name' ) ) ?>
					</a>
				</td>
			</tr>
			<tr>
				<td><?php _e( 'Addition note', 'tp-donate' ); ?></td>
				<td>
					<?php global $post; $donate_id = $post->ID ?>
					<?php $donation = DN_Donate::instance( $donate_id ); ?>
					<?php printf( '%s', $donation->get_meta( 'addition' ) ) ?>
				</td>
			</tr>
		</tbody>
	</table>


<?php endif; ?>
