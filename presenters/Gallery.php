<?php
	namespace Savioli\Presenters ;
	use Presenter ;

	class Gallery extends Presenter {

		static $actions = array(
			'load_gallery_single' => array('post_type' => 'page'),
			'load_gallery' => array('archive' => 'clipping')
		);

		static function build(){
			$presenter = get_called_class() ;
			parent::build();
		}

		static function load_gallery(){
			wp_enqueue_script('galleria', static::url('vendors/galleria/galleria-1.4.2.min.js'), array('jquery'), '1.4.2', true);
			wp_enqueue_script('galleria-default', static::url('js/galleria.js'), array('galleria'), false, true);
			wp_localize_script('galleria-default', 'Gallery', array(
				'theme_url' => static::url('vendors/galleria/themes/savioli/galleria.savioli.js')
			));

		}

		static function load_gallery_single(){
			global $post;
			if(strpos($post->post_content, '[gallery') === false) return ;
			static::load_gallery();
			remove_shortcode('gallery');
			add_shortcode('gallery', get_class($this).'::shortcode');
		}

		static function shortcode($attributes){
			global $post, $wp_locale;
		 	$output = "";
			if ( ! empty( $attributes['ids'] ) ) {
				if ( empty( $attributes['orderby'] ) )
					$attributes['orderby'] = 'post__in';
				$attributes['include'] = $attributes['ids'];
			}
		 
			extract(shortcode_atts(array(
				'orderby' => 'menu_order ASC, ID ASC',
				'include' => '',
				'id' => $post->ID,
				'itemtag' => 'dl',
				'icontag' => 'dt',
				'captiontag' => 'dd',
				'columns' => 3,
				'size' => 'medium',
				'link' => 'file'
			), $attributes));
		 
		 
			$args = array(
				'post_type' => 'attachment',
				'post_status' => 'inherit',
				'post_mime_type' => 'image',
				'orderby' => $orderby
			);
		 
			if ( !empty($include) )
				$args['include'] = $include;
			else {
				$args['post_parent'] = $id;
				$args['numberposts'] = -1;
			}
		 
			$images = get_posts($args);
			$output.= "<div class='galleria'>";
			foreach ( $images as $image ){     
				$caption = $image->post_excerpt;
				$description = $image->post_content;
				if($description == '') $description = $image->post_title;
				$image_alt = get_post_meta($image->ID,'_wp_attachment_image_alt', true);
			 	$output.= sprintf('<a href="%s">%s</a>',
			 		first(wp_get_attachment_image_src($image->ID, 'original')),
			 		wp_get_attachment_image($image->ID, 'thumbnail')
			 	);    
			}
			$output.= "</div>";

			return $output;
		}
	}
?>