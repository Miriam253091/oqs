<?php
if ( class_exists( 'THIM_Our_Team' ) ) {
	class Thim_Team_Widget extends Thim_Widget {
		function __construct() {
			parent::__construct(
				'team',
				__( 'Thim: Our Team', 'charitywp' ),
				array(
					'description'   => '',
					'help'          => '',
					'panels_groups' => array( 'thim_widget_group' ),
					'panels_icon'   => 'dashicons dashicons-groups'
				),
				array(),
				array(
					'source'        => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Source', 'charitywp' ),
						"options" 	=> array(
							"all"  	=> esc_html__( "All Members", 'charitywp' ),
							"id"   	=> esc_html__( "By ID", 'charitywp' ),
						),
						'state_emitter' => array(
							'callback' => 'select',
							'args'     => array( 'source' )
						)
					),

					'member_ids'   => array(
						'type'          => 'text',
						'label'         => esc_html__( 'Member IDs', 'charitywp' ),
						'description' 	=> esc_html__( 'i.e: 12,13,14,15,2,1,4,5', 'charitywp' ),
						'state_handler' => array(
							'source[all]'	=> array( 'hide' ),
							'source[id]' 	=> array( 'show' )
						),
					),

					'number'        => array(
						'type'    => 'number',
						'label'   => esc_html__( 'Number Members', 'charitywp' ),
						'default' => '8',
						'state_handler' => array(
							'source[all]'	=> array( 'show' ),
							'source[id]' 	=> array( 'hide' )
						),
					),

					'per_row'        => array(
						'type'    => 'number',
						'label'   => esc_html__( 'Number member in row', 'charitywp' ),
						'default' => '4',
						'state_handler' => array(
							'template[base]'	=> array( 'show' ),
							'template[carousel]' 	=> array( 'hide' )
						),
					),

					'visible'     => array(
						'type'    => 'number',
						'label'   => esc_html__( 'Number member visible', 'charitywp' ),
						'default' => '4',
						'state_handler' => array(
							'template[base]'	=> array( 'hide' ),
							'template[carousel]' 	=> array( 'show' )
						),
					),

					'orderby'      	=> array(
						"type"    	=> "select",
						"label"   	=> esc_html__( "Order by", 'charitywp' ),
						"options" 	=> array(
							"recent"  				=> esc_html__( "Recent", 'charitywp' ),
							"title"   				=> esc_html__( "Title", 'charitywp' ),
							"random"  				=> esc_html__( "Random", 'charitywp' )
						),
					),

					'order'        	=> array(
						"type"    	=> "select",
						"label"   	=> esc_html__( "Order", 'charitywp' ),
						"options" 	=> array(
							"asc"  	=> esc_html__( "ASC", 'charitywp' ),
							"desc" 	=> esc_html__( "DESC", 'charitywp' )
						),
					),

					'template'        	=> array(
						"type"    	=> "select",
						"label"   	=> esc_html__( "Template", 'charitywp' ),
						"options" 	=> array(
							"base"  	=> esc_html__( "Default", 'charitywp' ),
							"carousel" 	=> esc_html__( "Carousel", 'charitywp' )
						),
						'state_emitter' => array(
							'callback' => 'select',
							'args'     => array( 'template' )
						)
					),

					'display'        => array(
						'type'   => 'section',
						'label'  => esc_html__( 'Display Options', 'charitywp' ),
						'hide'   => true,
						'fields' => array(
							'link'          => array(
								'type'          => 'select',
								'label'         => esc_html__( 'Link To Detail', 'charitywp' ),
								'default'       => 'show',
								'options' 		=> array(
									'show' 		=> esc_html__('Show', 'charitywp'),
									'hidden'	=> esc_html__('Hidden', 'charitywp'),
								)
							),
							'facebook'          => array(
								'type'          => 'select',
								'label'         => esc_html__( 'Facebook', 'charitywp' ),
								'default'       => 'hidden',
								'options' 		=> array(
									'show' 		=> esc_html__('Show', 'charitywp'),
									'hidden'	=> esc_html__('Hidden', 'charitywp'),
								)
							),
							'twitter'          => array(
								'type'          => 'select',
								'label'         => esc_html__( 'Twitter', 'charitywp' ),
								'default'       => 'hidden',
								'options' 		=> array(
									'show' 		=> esc_html__('Show', 'charitywp'),
									'hidden'	=> esc_html__('Hidden', 'charitywp'),
								)
							),
							'rss'          => array(
								'type'          => 'select',
								'label'         => esc_html__( 'RSS', 'charitywp' ),
								'default'       => 'hidden',
								'options' 		=> array(
									'show' 		=> esc_html__('Show', 'charitywp'),
									'hidden'	=> esc_html__('Hidden', 'charitywp'),
								)
							),
							'skype'          => array(
								'type'          => 'select',
								'label'         => esc_html__( 'Skype', 'charitywp' ),
								'default'       => 'hidden',
								'options' 		=> array(
									'show' 		=> esc_html__('Show', 'charitywp'),
									'hidden'	=> esc_html__('Hidden', 'charitywp'),
								)
							),
							'dribbble'          => array(
								'type'          => 'select',
								'label'         => esc_html__( 'Dribbble', 'charitywp' ),
								'default'       => 'hidden',
								'options' 		=> array(
									'show' 		=> esc_html__('Show', 'charitywp'),
									'hidden'	=> esc_html__('Hidden', 'charitywp'),
								)
							),
							'linkedin'          => array(
								'type'          => 'select',
								'label'         => esc_html__( 'Linkedin', 'charitywp' ),
								'default'       => 'hidden',
								'options' 		=> array(
									'show' 		=> esc_html__('Show', 'charitywp'),
									'hidden'	=> esc_html__('Hidden', 'charitywp'),
								)
							),
							'phone'          => array(
								'type'          => 'select',
								'label'         => esc_html__( 'Phone', 'charitywp' ),
								'default'       => 'hidden',
								'options' 		=> array(
									'show' 		=> esc_html__('Show', 'charitywp'),
									'hidden'	=> esc_html__('Hidden', 'charitywp'),
								)
							),
							'email'          => array(
								'type'          => 'select',
								'label'         => esc_html__( 'Email', 'charitywp' ),
								'default'       => 'hidden',
								'options' 		=> array(
									'show' 		=> esc_html__('Show', 'charitywp'),
									'hidden'	=> esc_html__('Hidden', 'charitywp'),
								)
							),
							'content'          => array(
								'type'          => 'select',
								'label'         => esc_html__( 'Content', 'charitywp' ),
								'default'       => 'hidden',
								'options' 		=> array(
									'show' 		=> esc_html__('Show', 'charitywp'),
									'hidden'	=> esc_html__('Hidden', 'charitywp'),
								)
							),
						),
					),

				),

				THIM_DIR . 'inc/widgets/team/'
			);
		}

		/**
		 * Initialize the CTA widget
		 */


		function get_template_name( $instance ) {
			return isset($instance['template']) ? $instance['template'] : 'base';
		}

		function get_style_name( $instance ) {
			return false;
		}

	}

	function thim_team_register_widget() {
		register_widget( 'Thim_Team_Widget' );
	}

	add_action( 'widgets_init', 'thim_team_register_widget' );
}