<?php

class DN_Email
{
	static $instance = null;

	function __construct()
	{
		if( $this->is_enable() )
		{
			add_action( 'init', array( $this, 'init' ) );
		}
	}

	function init()
	{
		// filter email setting
		add_filter( 'wp_mail_from', array( $this, 'set_email_from' ) );

		// filter email from name
		add_filter( 'wp_mail_from_name', array( $this, 'set_email_name' ) );

		// filter content type
		add_filter( 'wp_mail_content_type', array( $this, 'email_content_type' ) );

		// filter charset
		add_filter( 'wp_mail_charset', array( $this, 'email_charset' ) );
	}

	// set email from
	function set_email_from( $email )
	{
		if( $donate_email = DN_Settings::instance()->email->get( 'admin_email' ) )
		{
			return $donate_email;
		}

		return $email;
	}

	// set email name header
	function set_email_name( $name )
	{
		if( $donate_name = DN_Settings::instance()->email->get( 'from_name' ) )
		{
			return sanitize_title( $donate_name );
		}
		return $name;
	}

	// filter content type
	function email_content_type( $type )
	{
		return 'text/html';
	}

	// filter charset
	function email_charset( $chartset )
	{
		return 'UTF-8';
	}

	// send email donate completed
	function send_email_donate_completed( $donor = null )
	{
		if( $this->is_enable() !== true )
			return;

		// email template
		$email_template = DN_Settings::instance()->email->get( 'email_template' );
		$email = $donor->get_meta( 'email' );
		if( $email && $email_template )
		{
			$subject = __( 'Donate completed', 'tp-donate' );

			$body = $email_template;

			$replace = array(
					'/\[(.*?)donor_first_name(.*?)\]/i',
					'/\[(.*?)donor_last_name(.*?)\]/i',
					'/\[(.*?)donor_phone(.*?)\]/i',
					'/\[(.*?)donor_email(.*?)\]/i',
					'/\[(.*?)donor_address(.*?)\]/i'
				);

			$replace_with = array(
					$donor->get_meta( 'first_name' ),
					$donor->get_meta( 'last_name' ),
					$donor->get_meta( 'phone' ),
					$donor->get_meta( 'email' ),
					$donor->get_meta( 'address' )
				);

			$body = preg_replace( $replace, $replace_with, $body );

			wp_mail( $email, $subject, $body);
		}
	}

	function is_enable()
	{
		if( DN_Settings::instance()->email->get( 'enable', 'yes' ) === 'yes' )
		{
			return true;
		}
	}

	// instance
	static function instance()
	{
		if( ! self::$instance )
		{
			return self::$instance = new self();
		}

		return self::$instance;
	}

}

DN_Email::instance();