<?php  
namespace Savioli;
class MagentoProduct {

	static function build(){
		$class = get_called_class();
		add_action('savioli_get_gioli_products', function() use($class){
			$options = get_option('clinica-savioli_options');
			$class::all($options['magento_url'], 6, true, true);
			$log = get_option('savioli_cron_log');
			if(!$log) $log = 1;
			update_option('savioli_cron_log', $log+1);
		});
		if(!wp_next_scheduled('savioli_get_gioli_products')){
			wp_schedule_event(time(),'hourly','savioli_get_gioli_products');
		}
		
	} 
	static function build_database(){}

	static function all($url, $ammount = 1, $full = true, $force = false){
		$products = get_transient('magento_products-'.$url);

		if(!($products) || $force){
			$html = file_get_dom($url);
			$grid = $html('.products-grid', 0);
			$products = array();
			foreach ($grid('li.item') as $product) {
				$object = new static();
				$object->name = $product('h3.product-name>a',0)->getPlainText();
				$object->url = $product('a.product-image',0)->href ;
				if(!$full){ $object->image = $product('a.product-image>img',0)->src ; 
				} else {
					$product = file_get_dom($object->url);
					$object->price = $product('.product-view .price-box .price', 0)->getPlainText();
					$object->image = $product('.product-view .product-img-box img', 0)->src;
				}

				$products[]= $object;
			}
			set_transient('magento_products-'.$url, $products, 60*60*2);
		}
		return array_slice($products, 0, $ammount);
	}

}

?>