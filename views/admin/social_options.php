<div class='wrap'>
	<div id='icon-themes' class='icon32'></div>
	<h2>Redes Sociais</h2>
	<form method='post' action='options.php'>
		<?php settings_fields('clinica-savioli_social_options') ?>
			<p>Links para redes sociais podem ser exibidos na barra superior do site.</p>
			<table class='form-table'>
				<tbody>
					<tr valign='top'>
						<th scope='row'>
							Habilitado?
						</th>
						<td>
							<input type='checkbox' name='clinica-savioli_social_options[enabled]' id='clinica-savioli_social_options_enabled' value='1' <?php checked(1,$options['enabled']) ?> />
							<span class='description'> Os ícones de redes sociais serão exibidos somente se estiverem habilitados.</span>
						</td>
					</tr>
					<tr valign='top'>
						<th scope='row'>
							Perfis
						</th>
						<td>
						<?php foreach($options['profiles'] as $profile => $url ): ?>
							<p>
							<label style='width: 200px;'><?php echo ucfirst($profile); ?>:</label></br>
							<input <?php html_attributes(array(
								'type' => 'text', 'name' => "clinica-savioli_social_options[profiles][$profile]",
								'value' => $url, 'size' => 60
							)) ?>>		
							</p>
						<?php endforeach ?>
						<p class='description'>Insira o link completo para cada perfil.</p>
						</td>
				</tbody>
			</table>
		<?php submit_button(); ?>
	</form>
</div>