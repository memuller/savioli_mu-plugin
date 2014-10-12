<?php
	namespace Savioli\Presenters ;
	use Presenter ;

	class Base extends Presenter {

		static $styles = array(
			'widgets' => array('from' => 'plugin', 'source' => '/css/widgets.css')
		);

		static $includes = array(
			array('is' => 'any', 'styles' => array('widgets'))
		);

		static function build(){
			$presenter = get_called_class();
			$base = '\Savioli\Plugin';
			parent::build();

			# removes image from the W3TC menu background (so it can use the Dashicons font).
			add_action('admin_footer', function(){?>
				<script>
					jQuery(function($){
						$('#toplevel_page_w3tc_dashboard .wp-menu-image').attr('style', "background: none !important;")
					});
				</script>
			<?php });

			# removes W3TC cache purge action from post lists at the admin.
			add_action( 'admin_head', function() {
				$screen = get_current_screen();
				add_filter('post_row_actions', function($actions) {
					if(isset($actions['pgcache_purge'])) unset($actions['pgcache_purge']) ;
					return $actions ;
				});
			});


			\Savioli\Presenters\Menu::setup_config_page();

			if($base::is_main_site()){
				static::setup_config();
				static::hide_menus();
			} else {
				static::setup_video_config();
			}
		}

		static function video_config(){
			add_action('admin_menu', function() use($presenter){
				add_submenu_page('edit.php?post_type=video', 'Configurações do Youtube', 'Configurações', 'manage_options', 'savioli_video_options', function() use($presenter){
						$options = get_option('tern_wp_youtube');
						if($_SERVER['REQUEST_METHOD'] == 'POST'){
							$options['channels'][1]['channel'] = $_POST['savioli_video_options']['channel'];
							update_option('tern_wp_youtube', $options);
						}
						if($_REQUEST['import']){
							WP_ayvpp_add_posts(1,'*');
						}

						$presenter::render('admin/video', array(
							'page' => '?page=savioli_video_options',
							'options' => array('channel' => $options['channels'][1]['channel'])
						));
				});	
			});
			add_action('admin_init', function(){
				register_setting('savioli_video_options', 'savioli_video_options') ;
			
			});
		}

		static function setup_config(){
			$presenter = get_called_class();
			add_action('admin_init', function(){
				register_setting('clinica-savioli_options', 'clinica-savioli_options');
			});
			add_action('admin_menu', function() use($presenter){
				add_submenu_page('options-general.php', 'Conteúdo Externo', 'Conteúdo Externo', 'manage_options', 'clinica-savioli_options', function() use($presenter){
						$presenter::render('admin/options', array(
							'active_tab' => isset($_GET['tab']) ? $_GET['tab'] : 'shipping', 
							'page' => '?page=clinica-savioli_options',
							'options' => array_merge(array(
								'blogs' => array(),
								'blogs_num_posts' => 2,
								'magento_url' => '',
								'magento_num_posts' => 3
							),get_option('clinica-savioli_options', array()))
						));
				});	
			});
		}

		static function hide_menus(){
			add_action('admin_menu', function(){
				global $menu;
				$restricted = array(__('Posts'), __('Comments'), 'Clippings');
				end ($menu);
				while (prev($menu)){
					$value = explode(' ',$menu[key($menu)][0]);
					if(in_array($value[0] != NULL?$value[0]:"" , $restricted))
						unset($menu[key($menu)]);
				}
			});
		}
	}
?>