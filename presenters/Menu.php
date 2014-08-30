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
					wp_enqueue_style('global-menu', $presenter::url('css/global.css'));
					add_action('wp_footer', function() use($presenter){
						$presenter::render('global', array('menus' => array(
							'Dr. Roque Savioli' => 'http://roque.clinicasavioli.com.br',
							'Dra. Gisela Savioli' => 'http://gisela.clinicasavioli.com.br',
							'Gioli' => 'http://gioli.clinicasavioli.com.br'
						)));
					});
				}
			});
			
		}
	}
?>