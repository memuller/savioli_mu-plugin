<?php
	namespace Savioli ;  
	use CustomPost ;

	class Product extends CustomPost {
		static $name = "product" ;
		static $creation_fields = array( 
			'label' => 'product','description' => "Um produtdo disponível para compra em um site terceiro",
			'public' => false,'show_ui' => true,'capability_type' => 'post', 'map_meta_cap' => true, 
			'hierarchical' => false,
			'supports' => array('custom-fields', 'title'), 
			'has_archive' => false, 'taxonomies' => array(),
			'labels' => array (
				'name' => 'Produtos',
				'singular_name' => 'Produto',
				'menu_name' => 'Produtos',
				'add_new' => 'Cadastrar Produto',
				'add_new_item' => 'Cadastrar Produto',
				'edit' => 'Atualizar',
				'edit_item' => 'Atualizar Produto',
				'new_item' => 'Registrar',
				'view' => 'Ver',
				'view_item' => 'Ver')
		);
		static $icon = '\f174' ;
		static $fields = array(
			'url' => array('type' => 'url', 'required' => true, 'label' => 'Endereço', 'description' => 'endereço utilizado quando o produto for clicado.'),
			'image' => array('type' => 'media', 'preview' => true, 'required' => true, 'label' => 'Imagem', 'description' => '')
		) ;

		static $editable_by = array(
			'form_advanced' => array('fields' => array('url','image')),
		);

		static $absent_actions = array('quick-edit');

		static $absent_collumns = array(
			'date'
		);

		static $collumns = array(
		);


		static function build(){
			parent::build();
			$class = get_called_class();
			add_action('savioli_import_products', function() use($class){
				$class::fetch("http://gioli.com.br");
			});
			if(!wp_next_scheduled('savioli_import_products')){
				wp_schedule_event(time(), 'hourly', 'savioli_import_products');
			}
			
		}

		static function imported_products(){
			return get_option('savioli_imported_products', array());
		}

		static function register_imported_product($url){
			$option = get_option('savioli_imported_products', array());
			$option[]= $url;
			update_option('savioli_imported_products', $option);	
		}

		static function fetch($store_url){
			$imported = static::imported_products();
			$html = $html = file_get_dom($store_url);
			$grid = $html('.products-grid', 0);
			$products = array();
			foreach ($grid('li.item') as $product) {
				$url = $product('a.product-image',0)->href;
				if(in_array($url, $imported)){
					continue; //skips already imported items
				}

				$name = $product('h3.product-name>a',0)->getPlainText();

				$html = file_get_dom($url);
				$image = $html('.product-view .product-img-box img',0)->src;

				$product = \Savioli\Product::create(array(
					'title' => $name,
					'image' => $image,
					'url' => $url,
				));
				static::register_imported_product($url);		
			}
		}


		
	}

 ?>