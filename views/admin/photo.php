<div class='wrap'>
	<h2>Configurações do Instagram</h2>
	<form method='POST' action='options.php'>
	<?php settings_fields('savioli_photo_options') ?>
		<table class='form-table'>
			<tbody>
				<tr valign='top'>
					<th scope='row'>
						Ativo?
					</th>
					<td>
						<input type='checkbox' name='savioli_photo_options[enabled]' id='savioli_photo_options-enabled' 
							value='1' <?php checked(1,$options['enabled']) ?> />
						<span>Exibir grid de fotos na página inicial</span>
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>
						Nome do Usuário
					</th>
					<td>
						<input <?php html_attributes(array('name' => 'savioli_photo_options[user_name]',
								'value' => $options['user_name'], 'size' => 50, 'type' => 'text', 'class' => 'text'
							)) ?>>
						<p class='description'>Nome do usuário cujas fotos serão exibidas.</p>
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>
						Código do Usuário
					</th>
					<td>
						<input <?php html_attributes(array('name' => 'savioli_photo_options[user_id]',
								'value' => $options['user_id'], 'size' => 50, 'type' => 'text', 'class' => 'text'
							)) ?>>
						<p class='description'>Código do usuário cujas fotos serão exibidas. </br>
						Obtenha <a href="http://jelled.com/instagram/lookup-user-id">aqui</a> o código de um usuário.
						</p>
					</td>
				</tr>
			</tbody>
		</table>
		<h3 class="title">Informações da API</h3>
		<p>
			Estas informações são necessárias para uso do Instagram. </br>
			Seu desenvolvedor pode ajudar a preenchê-las.	
		</p>
		<table class="form-table">
			<tbody>
				<tr valign='top'>
					<th scope='row'>
						Client Code
					</th>
					<td>
						<input <?php html_attributes(array('name' => 'savioli_photo_options[client_id]',
								'value' => $options['client_id'], 'size' => 50, 'type' => 'text', 'class' => 'text'
							)) ?>>
						<p class='description'>Código do cliente da API Instagram.</p>
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>
						oAuth Token
					</th>
					<td>
						<input <?php html_attributes(array('name' => 'savioli_photo_options[auth_token]',
								'value' => $options['auth_token'], 'size' => 50, 'type' => 'text', 'class' => 'text'
							)) ?>>
						<p class='description'>Código oAuth do cliente neste aplicativo.</p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>