<?php  
namespace Savioli;
use WP_Widget;
class BannerWidget extends WP_Widget {

	static function build(){
		add_action('widgets_init', function(){
			register_widget('\Savioli\BannerWidget');
		});
	} 

	function __construct(){
		parent::__construct(
			'banner',
			'Banner',
			array('description' => 'Exibe um banner previamente cadastrado.')
		);
	}

	public function widget($args, $instance){
		if(!$instance['banner']) return ;
		$banner = new \Savioli\Banner($instance['banner']);

		echo $args['before_widget'];?>
		
		<a href="<?php echo $banner->url ?>">
			<img src="<?php echo $banner->image ?>">
		</a>
		
		<?php echo $args['after_widget'];
	}

	public function form($instance){
		$banners = \Savioli\Banner::all(array('position' => 'sidebar', 'enabled' => true));
		if(!$banners){
			echo "<p>Não existem banners cadastrados na posição 'sidebar'. Nenhum banner será exibido.</p>" ;
		} else {
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'banner' ); ?>"><?php _e( 'Banner:' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'banner' ); ?>" name="<?php echo $this->get_field_name( 'banner' ); ?>">
					<?php foreach ($banners as $banner): ?>
						<option <?php html_attributes(array('value' => $banner->ID, 
							'selected' => $banner->ID == $instance['banner'])) ?>>
							<?php echo $banner->title ?>
						</option>
					<?php endforeach ?>
				</select>	
			</p>
		<?php }
	}

	public function update($new_instance, $old_instance){
		$instance = array();
		$instance['banner'] = $new_instance['banner'];
		return $instance ; 
	}


}

?>