<?php

class DN_Cart
{

	/**
	 * current cart items
	 * @var null
	 */
	public $cart_contents = null;

	/** @var null **/
	public $sessions = null;

	public $cart_total_include_tax = 0;
	public $cart_total 			= 0;
	public $cart_total_exclude_tax = 0;
	public $cart_items_count 	= 0;

	/**
	 * donate_cart
	 * @var null
	 */
	public $donate_info = null;
	public $addtion_note = null;
	public $donate_id = null;
	public $donor_id = null;

	// empty cart
	public $is_empty = true;

	/**
	 * instance insteadof new class();
	 * @var null
	 */
	static $_instance = null;

	function __construct()
	{
		// load cart items
		$this->sessions = DN_Sessions::instance( 'thimpress_donate_cart', true );
		$this->cart_contents = $this->get_cart();

		// refresh cart data
		$this->refresh();

		$this->donate_info = DN_Sessions::instance( 'thimpress_donate_info', true );
		$this->set_cart_information();

		add_action( 'init', array( $this, 'process_cart' ), 99 );
	}

	// process remove, update cart
	function process_cart()
	{
		if( ! isset( $_GET[ 'donate_remove_item' ] ) )
			return;

		$cart_item = sanitize_text_field( $_GET[ 'donate_remove_item' ] );
		$this->remove_cart_item( $cart_item );
		// redirect url
		wp_redirect( donate_cart_url() ); exit();
	}

	/**
	 * get list cart item
	 * @return array
	 */
	function get_cart()
	{
		$cart_items = array();

		if( $this->sessions && $this->sessions->session )
		{
			foreach ( $this->sessions->session as $cart_item_id => $cart_param ) {
				$param = new stdClass();

				// each all cart_param and add to cart_items
				foreach ( $cart_param as $key => $value ) {
					$param->{ $key } = $value;
				}

				if( $param->product_id )
				{
					$param->product_data = get_post( $param->product_id );

					$post_type = $param->product_data->post_type;
					$product_class = 'DN_Product_' . ucfirst( str_replace( 'dn_', '', $post_type) );
					if( ! class_exists( $product_class ) )
					 	$product_class = 'DN_Product_Base';

					 if( ! class_exists( $product_class ) )
					 	return new WP_Error( 'donate_cart_class_process_product', __( 'Class process product is not exists', 'tp-donate' ) );

					// class process product
					$param->product_class = apply_filters( 'donate_product_type_class', $product_class, $post_type );
					$product = new $param->product_class;

					// amount include tax
					$param->amount_include_tax = $param->amount; //$product->amount_include_tax();

					// amount exclude tax
					$param->amount_exclude_tax = $param->amount; //$product->amount_exclude_tax();

					// amount tax
					$param->tax = $param->amount_include_tax - $param->amount_exclude_tax;
				}

				// add to cart_items
				$cart_items[ $cart_item_id ] = $param;
			}
		}

		return apply_filters( 'donate_load_cart_from_session', $cart_items );
	}

	/**
	 * add to cart
	 * @param integer  $post_id
	 * @param array   $param
	 * @param integer $qty
	 */
	function add_to_cart( $post_id, $params = array(), $qty = 1, $amount = 0, $asc = false )
	{
		// generate cart item id by param
		$cart_item_id = $this->generate_cart_id( $params );

		if( in_array( $cart_item_id, $this->cart_contents ) )
		{
			if( $qty == 0 )
			{
				// remove item when qty = 0
				return $this->remove_cart_item( $cart_item_id );
			}

			if( $asc === false )
			{
				// remove item when is not asc
				$this->remove_cart_item( $cart_item_id );
			}
			else
			{
				$params[ 'quantity' ] = $this->cart_contents[ 'quantity' ] + $qty;
			}
		}
		else
		{
			$params[ 'quantity' ] = 1;
		}

		// only donate use
		$params[ 'amount' ] = $amount;

		// allow hook before set sessions
		do_action( 'donate_before_add_to_cart_item' );

		// set cart session
		$this->sessions->set( $cart_item_id, $params );

		// allow hook after set sessions
		do_action( 'donate_after_add_to_cart_item' );

		// refresh cart data
		$this->refresh();
		return $cart_item_id;
	}

	// refresh all
	function refresh()
	{
		// refresh cart_contents
		$this->cart_contents = $this->get_cart();

		// refresh cart_totals
		$this->cart_total_include_tax = $this->cart_total = $this->cart_total_include_tax();

		// refresh cart_totals_exclude_tax
		$this->cart_totals_exclude_tax = $this->cart_total_exclude_tax();

		// refresh cart_items_count
		$this->cart_items_count = count( $this->cart_contents );
	}

	// cart totals
	function cart_total_include_tax()
	{
		$total = 0;
		foreach ( $this->cart_contents as $cart_item_key => $cart_item ) {
			$total = $total + $cart_item->amount_include_tax;
		}
		// return total cart include tax
		return apply_filters( 'donate_cart_totals_include_tax', $total );
	}

	// set total
	function set_total()
	{
		return $this->cart_total_include_tax = $this->cart_total = apply_filters( 'donate_cart_set_total', 0 );
	}

	// cart exclude tax
	function cart_total_exclude_tax()
	{
		$total = 0;
		foreach ( $this->cart_contents as $cart_item_key => $cart_item ) {
			$total = $total + $cart_item->amount_exclude_tax;
		}
		// return total cart exclude tax
		return apply_filters( 'donate_cart_exclude_totals', $total );
	}

	// cart tax
	function cart_taxs()
	{
		$total = 0;
		foreach ( $this->cart_contents as $cart_item_key => $cart_item ) {
			$total = $total + $cart_item->tax;
		}
		// return cart tax total
		return apply_filters( 'donate_cart_tax_total', $total );
	}

	/**
	 * get cart item
	 */
	function get_cart_item( $item_key = null )
	{
		if( $item_key && isset( $this->cart_contents[ $item_key ] ) )
			return $this->cart_contents[ $item_key ];

		return new WP_Error( 'donate_cart_item_not_exists', sprintf( '%s %s', $item_key, __( 'cart item is not exists', 'tp-donate' ) ) );
	}

	/**
	 * get cart item
	 */
	function remove_cart_item( $item_key = null )
	{
		do_action( 'donate_remove_cart_item', $item_key );

		if( isset( $this->cart_contents[ $item_key ] ) )
		{
			unset( $this->cart_contents[ $item_key ] );
		}
		$this->sessions->set( $item_key, null );

		do_action( 'donate_removed_cart_item', $item_key );

		// return cart item removed
		return $item_key;
	}

	// set cart information. donor_id. donate_id. addtion_note
	function set_cart_information( $info = array() )
	{
		$info = wp_parse_args( $info, array(
				'addtion_note'	=> $this->donate_info->get( 'addtion_note' ),
				'donate_id'		=> $this->donate_info->get( 'donate_id' ),
				'donor_id'		=> $this->donate_info->get( 'donor_id' )
			));

		foreach ( $info as $key => $value ) {
			$this->donate_info->set( $key, $value );
			$this->{$key} = $value;
		}
	}

	// get cart information
	function get_cart_information( $key = null )
	{
		$infos = array(
				'addtion_note',
				'donate_id',
				'donor_id'
			);

		if( in_array( $key, $infos ) )
			return $this->{$key};
	}

	// destroy cart
	function remove_cart()
	{
		// remove
		$this->cart_contents = array();
		$this->sessions->remove();
		$this->donate_info->remove();

		// refresh cart contents
		$this->cart_contents = array();
		$this->refresh();
		$this->set_cart_information( array( 'addtion_note' => '', 'donate_id' => '', 'donor_id' => '', ) );
	}

	// return is empty
	function is_empty()
	{
		return $this->is_empty = ! empty( $this->cart_contents ) ? false : true;
	}

	/**
	 * generate cart item key
	 * @return string
	 */
	function generate_cart_id( $params = array() )
	{

		$html = array();
		ksort( $params );
		foreach ( $params as $key => $value ) {
			if( is_array( $value ) )
			{
				$html[] = $key . donate_array_to_string( $value );
			}
			else
			{
				$html[] = $key . $value;
			}
		}

		// return cart item id
		return apply_filters( 'donat_generate_cart_item_id', md5( implode( '', $html ) ) );
	}

	//instance
	static function instance()
	{
		if( ! empty( self::$_instance ) )
			return self::$_instance;

		return self::$_instance = new self();
	}

}
// var_dump(DN_Cart::instance()->cart_contents); die();