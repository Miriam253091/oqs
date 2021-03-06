<?php

/**
 * get status label with html
 */
if( ! function_exists( 'donate_get_status_label' ) )
{
	function donate_get_status_label( $post_id )
	{
		$status = array(
				'donate-cancelled'	=> '<label class="donate-status donate-cancelled">'.__( 'Cancelled', 'tp-donate' ).'</span>',
				'donate-pending'	=> '<label class="donate-status donate-pending">'.__( 'Pending', 'tp-donate' ).'</span>',
				'donate-processing'	=> '<label class="donate-status donate-processing">'.__( 'Processing', 'tp-donate' ).'</span>',
				'donate-completed'	=> '<label class="donate-status donate-completed">'.__( 'Completed', 'tp-donate' ).'</span>',
			);

		$post_status = get_post_status( $post_id );
		if( array_key_exists( $post_status, $status ) )
			return apply_filters( 'donate_get_status_label', $status[ $post_status ], $post_id );

	}
}

if( ! function_exists( 'donate_create_page' ) )
{
	function donate_create_page( $slug, $option = '', $page_title = '', $page_content = '', $post_parent = 0 ) {
	    global $wpdb;

	    $option_value     = get_option( $option );

	    if ( $option_value > 0 ) {
	        $page_object = get_post( $option_value );

	        if ( $page_object && 'page' === $page_object->post_type && ! in_array( $page_object->post_status, array( 'pending', 'trash', 'future', 'auto-draft' ) ) ) {
	            // Valid page is already in place
	            return $page_object->ID;
	        }
	    }

	    if ( strlen( $page_content ) > 0 ) {
	        // Search for an existing page with the specified page content (typically a shortcode)
	        $valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
	    } else {
	        // Search for an existing page with the specified page slug
	        $valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' )  AND post_name = %s LIMIT 1;", $slug ) );
	    }

	    $valid_page_found = apply_filters( 'donate_create_page_id', $valid_page_found, $slug, $page_content );

	    if ( $valid_page_found ) {
	        if ( $option ) {
	            update_option( $option, $valid_page_found );
	        }
	        return $valid_page_found;
	    }

	    // Search for a matching valid trashed page
	    if ( strlen( $page_content ) > 0 ) {
	        // Search for an existing page with the specified page content (typically a shortcode)
	        $trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
	    } else {
	        // Search for an existing page with the specified page slug
	        $trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_name = %s LIMIT 1;", $slug ) );
	    }

	    if ( $trashed_page_found ) {
	        $page_id   = $trashed_page_found;
	        $page_data = array(
	            'ID'             => $page_id,
	            'post_status'    => 'publish',
	        );
	        wp_update_post( $page_data );
	    } else {
	        $page_data = array(
	            'post_status'    => 'publish',
	            'post_type'      => 'page',
	            'post_author'    => 1,
	            'post_name'      => $slug,
	            'post_title'     => $page_title,
	            'post_content'   => $page_content,
	            'post_parent'    => $post_parent,
	            'comment_status' => 'closed'
	        );
	        $page_id = wp_insert_post( $page_data );
	    }

	    if ( $option ) {
	        update_option( $option, $page_id );
	    }

	    return $page_id;
	}

}


add_filter( 'post_row_actions', 'donate_post_row_actions', 10, 2 );
if( ! function_exists( 'donate_post_row_actions' ) )
{
	function donate_post_row_actions( $rows, $post )
	{
		if( in_array( $post->post_type , array( 'dn_donor', 'dn_donate' ) ) )
		{
			unset( $rows['view'] );
		}
		return $rows;
	}
}