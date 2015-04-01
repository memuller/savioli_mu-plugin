<?php
	namespace Savioli ;  
	use CustomPost ;

	class Banner extends CustomPost {
		static $name = "banner" ;
		static $creation_fields = array( 
			'label' => 'banner','description' => 'Um banner em uso no site.',
			'public' => false,'show_ui' => true,'capability_type' => 'post', 'map_meta_cap' => true, 
			'hierarchical' => false,
			'supports' => array('custom-fields'), 
			'has_archive' => false, 'taxonomies' => array(),
			'labels' => array (
				'name' => 'Banners',
				'singular_name' => 'Banner',
				'menu_name' => 'Banners',
				'add_new' => 'Cadastrar Banner',
				'add_new_item' => 'Cadastrar Banner',
				'edit' => 'Atualizar',
				'edit_item' => 'Atualizar Banner',
				'new_item' => 'Registrar',
				'view' => 'Ver',
				'view_item' => 'Ver')
		) ;
		static $icon = '\f116' ;
		static $fields = array(
			'url' => array('type' => 'url', 'required' => true, 'label' => 'Endereço', 'description' => 'endereço utilizado quando o banner for clicado.'),
			'image' => array('type' => 'media', 'preview' => true, 'required' => true, 'label' => 'Imagem'),
			'position' => array('type' => 'set', 'label' => 'Posição', 'values' => array(
				'featured' => 'Destaque', 'store' => 'Mais Produtos', 'sidebar' => 'Sidebar'
			)),
			'enabled' => array('type' => 'boolean', 'default' => true, 'label' => 'Ativo?')
		) ;

		static $editable_by = array(
			'form_advanced' => array('fields' => array('url','image')),
			'Controle' => array('fields' => array('enabled', 'position'), 'placing' => 'side')
		);

		static $absent_actions = array('quick-edit');

		static $absent_collumns = array(
			'date'
		);

		static $collumns = array(
			'position' => 'Posição',
			'active' => 'Ativo?'			
		);

		public function position(){
			echo static::$fields['position']['values'][$this->position] ;
		}

		public function active(){
			echo $this->enabled ? 'Sim' : 'Não';
		}


		static function build(){
			parent::build();
			

			add_action('savioli-banner-save', function($id, $data){
				$post = get_post($id);
				if($post->post_title == $data['url']) return ;
				wp_update_post(array('ID' => $id, 'post_title' => $data['url']));
			}, 10, 2);

		}
		
	}

 ?>