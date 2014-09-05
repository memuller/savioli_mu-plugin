<?php
	namespace Savioli ;
	use BasePlugin, SplFileObject ;

	class Plugin extends BasePlugin {

		static $db_version = '0.1' ;
		static $custom_posts = array('Banner', 'Clipping', 'Help');
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

	}

 ?>