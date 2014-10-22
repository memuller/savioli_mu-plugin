<?php
	namespace Savioli ;
	use BasePlugin, SplFileObject ;

	class Plugin extends BasePlugin {

		static $db_version = '0.2' ;
		static $custom_posts = array('Banner', 'Clipping', 'Video', 'Help');
		static $custom_taxonomies = array();
		static $custom_post_formats = array();
		static $custom_classes = array('MagentoProduct', 'MagentoWidget','BannerWidget', 'ForeignPost');
		static $custom_users = array('Editor');
		static $presenters = array('Gallery', 'Menu');
		static $has_translations = false ;

		static $absent_roles = array();
		static $restricted_menus = array();
		static $restrict_for_everyone = true;

		static $migrations = array(
			'0.2' => 'ayvp_settings'
		);

		static $query_vars = array(
		);
		static $rewrite_rules = array(
		);

		static function build(){
			parent::build();
			add_filter( 'got_rewrite', '__return_true', 999 );
		
		}

		static function main_site(){
			global $current_site;
			return defined('SAVIOLI_MAIN_SITE')?  SAVIOLI_MAIN_SITE : $current_site->blog_id; 
		}

		static function is_main_site(){
			return static::main_site() == get_current_blog_id();
		}

		static function migrate_ayvp_settings(){
			global $wpdb;
			$wpdb->delete($wpdb->options, array('option_name' => 'tern_wp_youtube'));
			$wpdb->insert($wpdb->options, array(
				'option_name' => 'tern_wp_youtube',
				'option_value' => 'a:15:{s:7:"publish";s:1:"0";s:12:"display_meta";s:1:"0";s:5:"words";s:2:"20";s:4:"dims";a:2:{i:0;s:3:"506";i:1;s:3:"304";}s:7:"related";s:1:"0";s:6:"inlist";s:1:"0";s:4:"cron";s:1:"6";s:4:"user";s:0:"";s:8:"channels";a:2:{i:1;a:6:{s:2:"id";i:1;s:4:"name";s:7:"Savioli";s:7:"channel";s:9:"dietacrua";s:4:"type";s:7:"channel";s:10:"categories";a:1:{i:0;s:1:"1";}s:6:"author";s:1:"1";}i:0;a:1:{s:7:"channel";s:18:"progviagemcultural";}}s:3:"rss";i:0;s:5:"limit";i:4;s:5:"pages";i:0;s:11:"last_import";i:1406047847;s:12:"is_importing";b:0;s:7:"version";i:206;}',
				'autoload' => 'yes'
			));
		}
	}

 ?>