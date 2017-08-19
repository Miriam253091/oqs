<?php
function thim_child_enqueue_styles() {
	// Enqueue parent style
	wp_enqueue_style( 'thim-parent-style', get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'thim_child_enqueue_styles', 100 );
function igni_CodeForm($atts, $content=null){
	
	/*extract(shortcode_atts(array(
	'curso_abierto' => '',
	'contact_list_evento' => '',
	'autoresponder_id' => '',
	
), $atts));*/

if(isset($_GET["w-places"]) && $_GET["w-places"]!=""){
	$places = $_GET["w-places"];
} else {
$places= 0;
}	
if(isset($_GET["e-type"]) && $_GET["e-type"]!=""){
	$places = $_GET["e-type"];
} else {
$event="default";
}	
if(isset($_GET["iva"]) && $_GET["iva"]!=""){
	$places = $_GET["iva"];
} else {
$iva= 0;
}	

	$evento_abierto =get_post_meta( get_the_ID(), 'evento_ab', true);
	  $cl_evento = get_post_meta( get_the_ID(), 'cl_evento', true);
	  $autoresponder_id = get_post_meta( get_the_ID(), 'auto_id', true);
	  $event_type = get_post_meta( get_the_ID(), 'event_type', true);

if (!$places){

$form = '<div id ="event-form-popup" class="mfp-hide form-popup" style="margin-top: 30px;">
	<div id="form-event-content">
		<p><h3 style="text-align:center;">Reserva tus lugares</h3></p>
		<form name="event" id="Event-form" action="http://reservacion.ojosquesienten.org/site/sp-event-register.php"  method="POST">
			<div class="row">
				<div class="col-xs-12">
											<!--allow set slot-->
						<div class="event_auth_form_field">
							<label class="sr-only" for="First_Name">Nombre</label>
							<input class="name" type="text" name="First_Name" id="First_Name" placeholder="Nombre">
							<label class="sr-only" for="First_Name">Apellido</label>
							<input class="name" type="text" name="Last_Name" id="Last_Name" placeholder="Apellido">
							<label class="sr-only" for="Email">Email</label>
							<input type="email" name="Email" id="Email" placeholder="Email">
							<!--<label class="sr-only" for="Alergies">Alergias/Necesidades especiales de Alimentación</label>
							<input type="text" name="Alergies" id="Alergies" placeholder="Alergias">-->
							<label for="event_register_qty">Cantidad</label>
							<input type="number" name="qty" value="1" min="1" id="event_register_qty">
						</div>
						<div class="event_auth_form_field">
							<label for="event_register_iva">¿Requieres factura? </label><br />							
							<input type="radio" name="iva" value="yes" id="event_register_iva"> Sí
							<input type="radio" name="iva" value="no" id="event_register_iva">No<br />
							<span class="payment-warning">Al seleccionar esta opción se te hara el cobro de un un 16% adcional al precio de cada boleto</span>
						</div>
						<input type="hidden" name="event_open" value="'.$evento_abierto.'" />
						<input type="hidden" name="event_cl" value="'.$cl_evento.'" />
						<input type="hidden" name="auto_id" value="'.$autoresponder_id.'" />
						<input type="hidden" name="event_type" value="'.$event_type.'" />
						
						<!--end allow set slot-->
									</div>
				<!--<div class="col-xs-12">
					<!--Hide payment option when cost is 0
					<label>Pago via</label>
											<div class="envent_auth_payment_methods">
							<input id="payment_method_paypal" type="radio" name="payment_method" value="paypal"><label for="payment_method_paypal"><img width="115" height="50" src="http://reservacion.ojosquesienten.org/site/wp-content/plugins/tp-event-auth/inc/payments/paypal.png"></label>						</div>
										<!--End hide payment option when cost is 0
				</div>-->
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="event_register_foot">
						<input type="hidden" name="event_id" value="4935">
						<input type="hidden" name="action" value="igni_wp_silverpop">
						<input type="hidden" name="_wp_http_referer" value="/OQS-new/events/big-night-walk/">						<!--<button class="event_register_submit event_auth_button thim-button style3">RESERVAR AHORA</button>-->
						<button class="thim-button style3" style="display: block; margin: 0 auto 20px;">RESERVAR AHORA</button>
						<p class="cprivacy1">*Completando este formulario accedes a recibir emails de Ojos que Sienten y puedes cancelarlos en cualquier momento (<a href="http://reservacion.ojosquesienten.org/site/aviso-de-privacidad/" target="_blank">Aviso de Privacidad</a>).</p>
					</div>
				</div>
			</div>

		</form>
		</div>
	</div>
';
} else {
$form='<div id ="event-form-popup" class="mfp-hide form-popup" style="margin-top: 30px;">
<p><h3 style="text-align:center;">PAGO</h3></p>
<iframe class="payment-frame" src="http://www.ojosquesienten.com/igni-payment.php?w-places='.$places.'&e-type='.$evnt.'&iva='.$iva.'></iframe>
<div>';
}

	return $form;
	
};

add_shortcode('igni_CodeForm', 'igni_CodeForm');

function add_query_vars($aVars) {
//$aVars[] = "w-places"; 
array_push($aVars, "w-places", "iva","e-type","e-email"); 
return $aVars;
}
 
// hook add_query_vars function into query_vars
add_filter('query_vars', 'add_query_vars');

function dwwp_add_custom_meta() {
    add_meta_box(
      'igni_meta_silverpop',
      'Integracón con Igni',
      'func_code',
      'tp_event',
      'side',
      'core'
    );
}
add_action( 'add_meta_boxes', 'dwwp_add_custom_meta' );




function func_code(){
	
	global $post;
	$values = get_post_custom( $post->ID );
	$evento_ab = isset( $values['evento_ab'] ) ? esc_attr( $values['evento_ab'][0] ) : "";
	$event_type = isset( $values['event_type'] ) ? esc_attr( $values['event_type'][0] ) : "";
	$cl_evento = isset( $values['cl_evento'] ) ? esc_attr( $values['cl_evento'][0] ) : "";
	$autoresponder_id = isset( $values['auto_id'] ) ? esc_attr( $values['auto_id'][0] ) : "";


	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); //genera un string de numeros para verificar el guardado
	?>
	
	<label for="evento_ab"><b>Evento abierto</b></label> <br />
    <input type="radio" name="evento_ab" id="evento_ab" value="1"<?php if( $evento_ab == 1){ echo 'checked';}  ?> /> Sí&nbsp;&nbsp;&nbsp;<input type="radio" name="evento_ab" id="evento_ab" value="0" <?php if( $evento_ab == 0){ echo 'checked';}  ?> /> No <br /><br />
    <label for="event_type"><b>Tipo de evento</b></label><br />
    <select name="event_type" id="event_type">
  	<option value="Cena" <?php if ($event_type == 'Cena') echo 'selected="selected"' ?>>Cena</option> 
  	<option value="Cata" <?php if ($event_type == 'Cata') echo 'selected="selected"' ?>>Cata</option>
  	<option value="Otro" <?php if ($event_type == 'Otro') echo 'selected="selected"' ?>>Otro</option>
  	</select><br /> <br />	
    <label for="cl_evento"><b>Contact List Evento</b></label>
    <input type="text" name="cl_evento" style="width: 100%;" id="cl_evento"  value="<?php echo $cl_evento; ?>"/><br />
    <br />
	<label for="auto_id"><b>Autoresponder ID</b></label>
    <input type="text" name="auto_id" id="auto_id" style="width: 100%" value="<?php echo $autoresponder_id; ?>"/><br />
	<?php
}
add_action( 'save_post', 'code_save' );

function code_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
    
// Asegurarse de que los campos esten llenos antes de enviarlos,y sí hacer eso con c/u
    
    if( isset( $_POST['evento_ab'] ) )
        update_post_meta( $post_id, 'evento_ab', $_POST['evento_ab'] );
    
	if( isset( $_POST['event_type'] ) )
        update_post_meta( $post_id, 'event_type', $_POST['event_type'] );
    
    if( isset( $_POST['cl_evento'] ) )
        update_post_meta( $post_id, 'cl_evento',  $_POST['cl_evento'] );  
    
    if( isset( $_POST['auto_id'] ) )
        update_post_meta( $post_id, 'auto_id',  $_POST['auto_id'] );
}

/*register post types hkn*/
	add_action('init', function(){
		// GALERIA DE FOTOS
		$labels = array(
			'name'          => 'Galerías',
			'singular_name' => 'Galería',
			'add_new'       => 'Nueva Galería',
			'add_new_item'  => 'Nueva Galería',
			'edit_item'     => 'Editar Galería',
			'new_item'      => 'Nueva Galería',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Galería',
			'search_items'  => 'Buscar Galería',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Galerías'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'galerias' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 6,
			'taxonomies'         => array( 'category' ),
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'galerias', $args );
		
	});


