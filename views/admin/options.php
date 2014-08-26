<div class='wrap'>
	<div id='icon-themes' class='icon32'></div>
	<h2>Conteúdo Externo</h2>
	<form method='post' action='options.php'>
		<?php settings_fields('clinica-savioli_options') ?>
			<h3 class="title">Blogs</h3>
			<p>O conteúdo destes blogs será utilizado para preencher a página inicial do site.</p>
			<table class='form-table'>
				<tbody>
					<tr valign='top'>
						<th scope='row'>
							Blogs
						</th>
						<td>
							<?php foreach (array(1,2) as $i): ?>
								<select <?php html_attributes(array(
									'name' => "clinica-savioli_options[blogs][$i]"
								));?>>
									<?php foreach (wp_get_sites() as $site): ?>
										<?php if(get_current_blog_id() == $site['blog_id']) continue; ?>
										<option <?php html_attributes(array('value' => $site['blog_id'],
											'selected' => $options['blogs'][$i] == $site['blog_id']
										))?>>
											<?php echo $site['domain']. $site['path'] ?>
										</option>
									<?php endforeach ?>
								</select></br>	
							<?php endforeach ?>
						</td>
					</tr>
					<tr valign='top'>
						<th scope='row'>
							Quantidade de Posts
						</th>
						<td>
							<input type='number' name='clinica-savioli_options[blogs_num_posts]' 
								value='<?php echo $options['blogs_num_posts'] ?>'/>
						</td>
				</tbody>
			</table>
			<h3 class="title">Produtos do Magento</h3>
			<p>Produtos em destaque de uma loja Magento serão automaticamente utilizados em partes específicas do site.</p>	
			<table class='form-table'>
				<tbody>
					<tr valign='top'>
						<th scope='row'>
							Endereço da Loja
						</th>
						<td>
							<input <?php html_attributes(array('name' => 'clinica-savioli_options[magento_url]',
								'value' => $options['magento_url'], 'size' => 50, 'type' => 'url', 'class' => 'text'
							)) ?>>			
						</td>
					</tr>
					<tr valign='top'>
						<th scope='row'>
							Quantidade de Produtos
						</th>
						<td>
							<input type='number' name='clinica-savioli_options[magento_num_posts]' 
								value='<?php echo $options['magento_num_posts'] ?>'/>
						</td>
					</tr>
				</tbody>
			</table>
		<?php submit_button(); ?>
	</form>
</div>