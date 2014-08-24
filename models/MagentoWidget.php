<?php  
namespace Savioli;
use WP_Widget;
class MagentoWidget extends WP_Widget {
	
	static $magento_class = '\Savioli\MagentoProduct';

	static function build(){
		add_action('widgets_init', function(){
			register_widget('\Savioli\MagentoWidget');
		});
	} 

	function __construct(){
		parent::__construct(
			'magento_products',
			'Últimos Produtos Magento',
			array('description' => 'Exibe os últimos produtos de uma loja Magento.')
		);
	}

	public function widget($args, $instance){
		echo $args['before_widget'];
		$magento = static::$magento_class ;
		$products = $magento::all($instance['url'], $instance['ammount']);
		$title = apply_filters( 'widget_title', $instance['title'] ); ?>
		<div class="widget-title">
			<h3><?php echo $title ?></h3>
		</div>	
		<ul>
			<?php foreach ($products as $item): ?>
				<li>
					<a href="<?php echo $item->url ?>">
						<img src="<?php echo $item->image ?>" title="<?php echo $item->name ?>">
					</a>
				</li>
			<?php endforeach ?>
		</ul>
		<?php echo $args['after_widget'];
	}

	public function form($instance){
		$title = isset($instance['title']) ? $instance['title'] : 'Último Produto' ;
		$url = $instance['url'];
		$ammount = isset($instance['ammount']) ? $instance['ammount'] : 1 ;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Url:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'ammount' ); ?>"><?php echo 'Quantidade'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'ammount' ); ?>" name="<?php echo $this->get_field_name( 'ammount' ); ?>" type="text" value="<?php echo esc_attr( $ammount ); ?>">
		</p>
	<?php }

	public function update($new_instance, $old_instance){
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = strip_tags($new_instance['url']);
		$instance['ammount'] = intval($new_instance['ammount']);
		return $instance ; 
	}


}

?>