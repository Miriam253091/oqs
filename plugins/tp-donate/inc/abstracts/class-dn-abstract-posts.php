<?php

abstract class DN_Post_Base
{

	/**
	 * ID of Post
	 * @var null
	 */
	protected $ID = null;

	/**
	 * post
	 * @var null
	 */
	protected $post = null;

	/**
	 * meta prefix of post type
	 * @var null
	 */
	protected $meta_prefix = null;

	/**
	 * post type
	 * @var null
	 */
	protected $post_type = null;

	function __construct( $post = null )
	{
		if( is_numeric( $post ) )
			$this->post = get_post( $post );

		if( $post instanceof WP_Post )
			$this->post = $post;

		if( $this->post )
		{
			$this->ID = $this->post->ID;
		}
	}

	/**
	 * get key of post
	 * @param $key
	 * @return *
	 */
	function __get( $key )
	{
		if( ! $this->post )
			return;

		if( ! $this->post->{$key} )
			return;

		return $this->post->{$key};
	}

	// get post meta
	function get_meta( $key, $unique = true )
	{
		if( $meta = get_post_meta( $this->ID, $this->meta_prefix . $key , $unique ) )
			return $meta;

		return null;
	}

	// update post meta
	function update_meta( $key, $value )
	{
		update_post_meta( $this->ID, $this->meta_prefix . $key , $value );
	}

	// set post meta
	function set_meta( $key, $val = '', $unique = false )
	{
		if( $key ) {
			update_post_meta( $this->ID, $this->meta_prefix . $key, $val, $unique );
		}
	}

	/**
	 * create post with post type = $this->post_type
	 * @param  array  $args
	 * @return
	 */
	function create_post( $args = array() )
	{
		$default = array(
			'post_title'	=> '',
			'post_content'	=> '',
			'post_author'	=> 1,
			'post_status'	=> 'publish',
			'post_type'		=> $this->post_type
		);

		$default = apply_filters( 'donate_create_post_default', $default, $this->post_type );

		$post = wp_parse_args( $args, $default );

		$default = apply_filters( 'donate_create_post_default', $default, $this->post_type );

		do_action( 'donate_before_insert_post', $this->post_type );

		$id = wp_insert_post( $post, true );

		do_action( 'donate_after_insert_post', $id );

		return $id;
	}

}
