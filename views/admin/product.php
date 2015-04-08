<div class='wrap'>
	<div id='icon-themes' class='icon32'></div>
	<h2>Configuração de Produtos</h2>
	<form method='post' action="edit.php?post_type=product&page=savioli_product_options">
		<?php settings_fields('savioli_product_options') ?>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							Número de produtos
						</th>
						<td>
							<input type="number" name="savioli_product_options[num_products]" class="text" 
								<?php html_attributes(array( 'value' => $options['num_products'] )) ?>
							></br>
							<span class="description">quantidade de produtos exibida na página inicial.</span>
						</td>
					</tr>
				</tbody>
			</table>
			<h3 class="title">Importação do Magento</h3>
			<p>Você pode cadastrar uma loja Magento, cujos produtos atuais e futuros serão automaticamente cadastrados. </br>
			Fazendo isso ou não, sempre poderá cadastrar ou alterar produtos manualmente.
			</p>	
			<table class='form-table'>
				<tbody>
					<tr valign='top'>
						<th scope='row'>
							Habilitado?
						</th>
						<td>
							<input type="checkbox" name="savioli_product_options[magento_import_enabled]" value="1" <?php checked(1, $options['magento_import_enabled']) ?>>
							<span>Importar produtos da loja Magento abaixo</span>
						</td>
					</tr>
					<tr valign='top'>
						<th scope='row'>
							URL da loja
						</th>
						<td>
							<input <?php html_attributes(array('name' => 'savioli_product_options[magento_url]',
								'value' => $options['magento_url'], 'size' => 50, 'type' => 'url', 'class' => 'text'
							)) ?>></br>
							<span class="description">use a URL completa da página inicial da loja.</span>			
						</td>
					</tr>
				</tbody>
			</table>
		<?php submit_button(); ?>
	</form>
</div>