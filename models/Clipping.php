<?php
	namespace Savioli ;  
	use CustomPost ;

	class Clipping extends CustomPost {
		static $name = "clipping" ;
		static $creation_fields = array( 
			'label' => 'clipping','description' => 'Um recorte de mídia.',
			'public' => true,'show_ui' => true,'capability_type' => 'post', 'map_meta_cap' => true, 
			'hierarchical' => false, 'rewrite' => array('slug' => 'clippings'), 'query_var' => true,
			'supports' => array('custom-fields', 'title'), 
			'has_archive' => true, 'taxonomies' => array(),
			'labels' => array (
				'name' => 'Clippings',
				'singular_name' => 'Clipping',
				'menu_name' => 'Clippings',
				'add_new' => 'Cadastrar Clipping',
				'add_new_item' => 'Cadastrar Clipping',
				'edit' => 'Atualizar',
				'edit_item' => 'Atualizar Clipping',
				'new_item' => 'Registrar',
				'view' => 'Ver',
				'view_item' => 'Ver')
		) ;
		static $icon = '\f318' ;
		static $fields = array(
			'image' => array('type' => 'media', 'preview' => true, 'required' => true, 'label' => 'Imagem'),
		) ;

		static $editable_by = array(
			'form_advanced' => array('fields' => array('image'))
		);

		static $absent_actions = array('quick-edit');

		static $absent_collumns = array(
		);

		static $collumns = array(			
		);

		static function build(){
			parent::build();
		}
		
	}

 ?>