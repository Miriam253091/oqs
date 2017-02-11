<?php

class Thim_Google_Map_Widget extends Thim_Widget {
	function __construct() {
 		parent::__construct(
			'google-map',
			__( 'Thim: Google Maps', 'charitywp' ),
			array(
				'description' => esc_html__( 'A Google Maps widget.', 'charitywp' ),
				'help'        => '',
				'panels_groups' => array('thim_widget_group')
			),
			array(),
			array(
				'title'      => array(
					'type'  => 'text',
					'label' => esc_html__( 'Title', 'charitywp' ),
				),
				'map_center' => array(
					'type'        => 'textarea',
					'rows'        => 2,
					'label'       => esc_html__( 'Map center', 'charitywp' ),
					'description' => esc_html__( 'The name of a place, town, city, or even a country. Can be an exact address too.', 'charitywp' )
				),
				'settings'   => array(
					'type'        => 'section',
					'label'       => esc_html__( 'Settings', 'charitywp' ),
					'hide'        => false,
					'description' => esc_html__( 'Set map display options.', 'charitywp' ),
					'fields'      => array(
						'height'      => array(
							'type'    => 'text',
							'default' => 480,
							'label'   => esc_html__( 'Height', 'charitywp' )
						),
						'zoom'        => array(
							'type'        => 'slider',
							'label'       => esc_html__( 'Zoom level', 'charitywp' ),
							'description' => esc_html__( 'A value from 0 (the world) to 21 (street level).', 'charitywp' ),
							'min'         => 0,
							'max'         => 21,
							'default'     => 12,
							'integer'     => true,

						),
						'scroll_zoom' => array(
							'type'        => 'checkbox',
							'default'     => true,
							'state_name'  => 'interactive',
							'label'       => esc_html__( 'Scroll to zoom', 'charitywp' ),
							'description' => esc_html__( 'Allow scrolling over the map to zoom in or out.', 'charitywp' )
						),
						'draggable'   => array(
							'type'        => 'checkbox',
							'default'     => true,
							'state_name'  => 'interactive',
							'label'       => esc_html__( 'Draggable', 'charitywp' ),
							'description' => esc_html__( 'Allow dragging the map to move it around.', 'charitywp' )
						)
					)
				),
				'markers'    => array(
					'type'        => 'section',
					'label'       => esc_html__( 'Markers', 'charitywp' ),
					'hide'        => true,
					'description' => esc_html__( 'Use markers to identify points of interest on the map.', 'charitywp' ),
					'fields'      => array(
						'marker_at_center' => array(
							'type'    => 'checkbox',
							'default' => true,
							'label'   => esc_html__( 'Show marker at map center', 'charitywp' )
						),
						'marker_icon'      => array(
							'type'        => 'media',
							'default'     => '',
							'label'       => esc_html__( 'Marker Icon', 'charitywp' ),
							'description' => esc_html__( 'Replaces the default map marker with your own image.', 'charitywp' )
						),
//						'markers_draggable' => array(
//							'type'       => 'checkbox',
//							'default'    => false,
//							'state_name' => 'interactive',
//							'label'      => esc_html__( 'Draggable markers', 'charitywp' )
//						),
						'marker_positions'  => array(
							'type'       => 'repeater',
							'label'      => esc_html__( 'Marker positions', 'charitywp' ),
							'item_name'  => esc_html__( 'Marker', 'charitywp' ),
//							'item_label' => array(
//							 'selector'     => "[id*='marker_positions-place']",
//								'update_event' => 'change',
//								'value_method' => 'val'
//							),
							'fields'     => array(
								'place' => array(
									'type'  => 'textarea',
									'rows'  => 2,
									'label' => esc_html__( 'Place', 'charitywp' )
								)
							)
						)
					)
				),
			)
		);
	}

	function enqueue_frontend_scripts() {
		wp_enqueue_script( 'thim-google-map', THIM_URI . 'inc/widgets/google-map/js/js-google-map.js', array( 'jquery' ), true );
	}

	function get_template_name( $instance ) {
		return 'base';
	}

	function get_style_name( $instance ) {
		return false;
	}

	function get_template_variables( $instance, $args ) {
		$settings = $instance['settings'];
		$markers  = $instance['markers'];
 		$mrkr_src = wp_get_attachment_image_src( $instance['markers']['marker_icon'] );
		{
			return array(
				'map_id'   => md5( $instance['map_center'] ),
				'height'   => $settings['height'],
				'map_data' => array(
					'address'          => $instance['map_center'],
					'zoom'             => $settings['zoom'],
					'scroll-zoom'      => $settings['scroll_zoom'],
					'draggable'        => $settings['draggable'],
					'marker-icon'      => !empty( $mrkr_src ) ? $mrkr_src[0] : '',
 				//	'markers-draggable' => isset( $markers['markers_draggable'] ) ? $markers['markers_draggable'] : '',
					'marker-at-center'  => $markers['marker_at_center'],
					'marker-positions'  => isset( $markers['marker_positions'] ) ? json_encode( $markers['marker_positions'] ) : '',
				)
			);
		}
	}
}
//
function thim_google_map_widget() {
	register_widget( 'Thim_Google_Map_Widget' );
}

add_action( 'widgets_init', 'thim_google_map_widget' );