<?php
	namespace Savioli ;  
	use CustomPost ;

	class Help extends CustomPost {
		static $name = "help" ;
		static $creation_fields = array( 
			'label' => 'help','description' => 'Uma página de ajuda.',
			'public' => false,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post', 'map_meta_cap' => true, 
			'hierarchical' => true,
			'supports' => array('custom-fields', 'title', 'editor', 'page-attributes'), 
			'has_archive' => false, 'taxonomies' => array(),
			'labels' => array (
				'name' => 'Ajuda',
				'singular_name' => 'Página de Ajuda',
				'menu_name' => 'Ajuda',
				'add_new' => 'Nova página',
				'add_new_item' => 'Nova página',
				'edit' => 'Atualizar',
				'edit_item' => 'Editar página',
				'new_item' => 'Registrar',
				'view' => 'Ver',
				'view_item' => 'Ver'),
			 'menu_position' => 80 
		) ;
		static $icon = '\f223';
		static $fields = array(
			'description' => array('label' => 'Descrição', 'type' => 'text_area')
		) ;

		static $editable_by = array(
			'form_advanced' => array('fields' => array('description'))
		);

		static $absent_actions = array('quick-edit');

		static $absent_collumns = array(
			'views', 'likes', 'ws_plugin__s2member_pro_lock_icons', 'ws_plugin__wp_show_ids', 'date'
		);

		static $collumns = array(
			'description' => 'Descrição'
		);

		public function description(){
			return "<em>$this->description</em>" ;
		}

		static function build(){
			$class = get_called_class();
			parent::build();
			add_action('admin_menu', function(){
				if(!current_user_can('manage_options')){
					remove_submenu_page('edit.php?post_type=help', 'post-new.php?post_type=help') ;
				}
			});
			add_action('admin_print_scripts', function(){
				$screen = get_current_screen();
				if($screen->post_type == 'help'){
					add_thickbox();?>
						<script>
							jQuery(function($){
								$('#the-list').on('click', 'a.row-title', function(event){
									event.preventDefault();
									$(this).parent().nextAll('.row-actions').find('.view a').click();
								});
							});
						</script>
					<?php 
					if(!current_user_can('manage_options')){?>
						<style> 
						.add-new-h2 { display: none; }
						</style>
					<?php }
				}
			}, 99);
			add_filter('atlas-help-page_row_actions', function($actions) use($class){
				if(!current_user_can('manage_options'))
					unset($actions['edit']);
				$object = new $class();
				$actions['view'] = sprintf("<a class='thickbox' href='%s' title='%s'>%s</a>
					<div id='%s' style='display:none;'><div>%s</div></div>", 
					"#TB_inline?width=800&height=600&inlineId=help-$object->ID", $object->title, __('View'), 
					'help-'.$object->ID, apply_filters('the_content',$object->content));
				return $actions;
			});
		}
		
	}

 ?>