	</body>
	<footer id="landing_footer">
		<section id="the_map_concert">
			<?php if( is_page('concierto-en-la-oscuridad') ): ?>
				<div>
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.8412122632735!2d-99.15805138458327!3d19.41926554613781!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x61a70980ea06f162!2sOjos+Que+Sienten!5e0!3m2!1sen!2smx!4v1502663232963" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
		<?php endif; ?>
			<div>
				<ul id="footer_contact_list">
					<li class="fc_item">
						<a href="ojosquesienten.com">©2017www.ojosquesienten.com</a>
					</li>
					<li class="fc_item">
						<a href="callto:+52-1-5207-04119"><i class="fa fa-phone" aria-hidden="true"></i>(55)5207 04119 / (55)5533 1850</a>
					</li>
					<li class="fc_item">
						<a href="mailto:equipo@ojosquesienten.com"><i class="fa fa-envelope" aria-hidden="true"></i>equipo@ojosquesienten.com</a>
					</li>
				</ul>
			</div>
		</section>
	</footer>
	<section class="overscreen darkblue_bg" id="lan_mobile_menu">
		<ul>
			<li>
				<a href="<?php echo bloginfo('url').'/concierto-en-la-oscuridad'; ?>">Inicio</a>
			</li>
			<li>
				<a href="<?php echo bloginfo('url').'/artistas'; ?>">Artistas</a>
			</li>
			<li>
				<a href="<?php echo bloginfo('url'). '/apoya-causa'; ?>">Apoya la causa</a>
			</li>
			<li>
				<a href="<?php echo esc_url( site_url() ); ?>">Fundación Ojos que Sienten</a>
			</li>
		</ul>
	</section>
</html>	