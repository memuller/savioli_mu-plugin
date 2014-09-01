<?php
	namespace Savioli\Presenters ;
	use Presenter ;

	class Menu extends Presenter {

		static $actions = array(

		);

		static function build(){
			$presenter = get_called_class() ;
			parent::build();
			add_action('wp_enqueue_scripts', function() use($presenter){
				if(!is_user_logged_in()){
					wp_enqueue_style('genericons', $presenter::url('vendors/genericons/genericons/genericons.css'));
					wp_enqueue_style('global-menu', $presenter::url('css/global.css'));
					add_action('wp_footer', function() use($presenter){
						$presenter::render('global', array('menus' => array(
							'Dr. Roque Savioli' => 'http://roque.clinicasavioli.com.br',
							'Dra. Gisela Savioli' => 'http://gisela.clinicasavioli.com.br',
							'Gioli' => 'http://gioli.clinicasavioli.com.br'
						),
						'social' => get_option('clinica-savioli_social_options')
						));
					});
				}
			});
			
		}
		static function setup_config_page(){
			$presenter = get_called_class();
			add_action('admin_init', function(){
				register_setting('clinica-savioli_social_options', 'clinica-savioli_social_options');
			});
			add_action('admin_menu', function() use($presenter){
				add_submenu_page('options-general.php', 'Redes sociais', 'Redes sociais', 'manage_options', 'clinica-savioli_social_options', function() use($presenter){
						$presenter::render('admin/social_options', array( 
							'page' => '?page=clinica-savioli_social_options',
							'options' => array_merge(array(
								'enabled' => true,
								'profiles' => array(
									'facebook' => '',
									'googleplus' => '',									
									'twitter' => '',
									'instagram' => '',
									'youtube' => ''
								)
							),get_option('clinica-savioli_social_options', array()))
						));
				});	
			});
		}
	}
?>