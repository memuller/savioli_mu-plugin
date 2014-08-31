<?php
	namespace Savioli\Presenters ;
	use Presenter ;

	class Gallery extends Presenter {

		static $actions = array(
			'load_gallery' => array('post_type' => 'page')
		);

		static function build(){
			$presenter = get_called_class() ;
			parent::build();
		}

		static function load_gallery(){
			global $post;
			if(strpos($post->post_content, '[gallery') === false) return ;
			wp_enqueue_script('galleria', static::url('vendors/galleria/galleria-1.4.2.min.js'), array('jquery'), '1.4.2', true);
			wp_enqueue_script('galleria-default', static::url('js/galleria.js'), array('galleria'), false, true);
			wp_localize_script('galleria-default', 'Gallery', array(
				'theme_url' => static::url('vendors/galleria/themes/savioli/galleria.savioli.js')
			));
			remove_shortcode('gallery');
			add_shortcode('gallery', get_class($this).'::shortcode');
		}

		static function shortcode($attributes){
			global $post;
		 
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
			?>
			<div class='galleria'>
				<?php foreach ( $images as $image ){     
					$caption = $image->post_excerpt;
					$description = $image->post_content;
					if($description == '') $description = $image->post_title;
					$image_alt = get_post_meta($image->ID,'_wp_attachment_image_alt', true);?>
			 		<a href="<?php echo first(wp_get_attachment_image_src($image->ID, 'original')) ?>">
			 			<?php echo wp_get_attachment_image($image->ID, 'thumbnail'); ?>
			 		</a>    
				<?php }?>
			</div>
			<?php 
		}
	}
?>