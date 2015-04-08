<?php
	namespace Savioli\Presenters ;
	use Presenter ;

	class Base extends Presenter {

		static $styles = array(
			'widgets' => array('from' => 'plugin', 'source' => '/css/widgets.css')
		);

		static $scripts = array(
			'instafeed' => array('from' => 'plugin', 'source' => '/vendors/instafeed/instafeed.min.js',
				'localize' => array('Instagram', 'localize_instagram'), 'dependencies' => array('jquery'))
		);

		static $includes = array(
			array('is' => 'any', 'styles' => array('widgets')),
			array('if' => 'isblog', 'is' => 'home', 'scripts' => array('instafeed'))
		);

		static function localize_instagram(){
			$options = get_option('savioli_photo_options');
			return array(
				'client_id' => $options['client_id'],
				'auth_token' => $options['auth_token'],
				'user_id' => $options['user_id'],
			);
		}

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
			static::product_config();

			if($base::is_main_site()){
				static::setup_config();
				static::hide_menus();
			} else {
				static::video_config();
				static::photo_config();
			}
		}

		static function isblog(){
			$base = '\Savioli\Plugin';
			return !$base::is_main_site();
		}
		static function video_config(){
			$presenter = get_called_class();
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

						if($_REQUEST['reset']){
							$options = get_option('tern_wp_youtube');
							$channel = $options['channels'][1]['channel']; 
							\Savioli\Plugin::migrate_ayvp_settings();
							$options = get_option('tern_wp_youtube');
							$options['channels'][1]['channel'] = $channel;
							update_option('tern_wp_youtube', $options);
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

		static function product_config(){
			$presenter = get_called_class();
			add_action('admin_menu', function() use($presenter){
				add_submenu_page('edit.php?post_type=product', 'Configurações dos Produtos', 'Configurações', 'manage_options', 'savioli_product_options', function() use($presenter){
						$options = get_option('savioli_product_options');
						if($_SERVER['REQUEST_METHOD'] == 'POST'){
							update_option('savioli_product_options', $options);
						}

						$presenter::render('admin/product', array(
							'options' => array_merge(array(
								'num_products' => 4,
								'magento_import_enabled' => false,
								'magento_url' => ''
							), $options ),
							'page' => '?post_type=product&page=savioli_product_options',
						));
				});	
			});
			add_action('admin_init', function(){
				register_setting('savioli_product_options', 'savioli_product_options') ;
			
			});
		}

		static function photo_config(){
			$presenter = get_called_class();
			add_action('admin_menu', function() use($presenter){
				add_submenu_page('options-general.php', 'Configurações do Instagram', 'Instagram', 'manage_options', 'savioli_photo_options', function() use($presenter){
						$options = get_option('savioli_photo_options');
						if($_SERVER['REQUEST_METHOD'] == 'POST'){
							update_option('savioli_photo_options', $options);
						}

						$presenter::render('admin/photo', array(
							'page' => '?page=savioli_photo_options',
							'options' => $options
						));
				});	
			});
			add_action('admin_init', function(){
				register_setting('savioli_photo_options', 'savioli_photo_options') ;
			
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
								'blogs_num_posts' => 2
							),get_option('clinica-savioli_options', array()))
						));
				});	
			});
		}

		static function hide_menus(){
			add_action('admin_menu', function(){
				global $menu;
				$restricted = array(__('Posts'), __('Comments'), 'Clippings', "Vídeos");
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