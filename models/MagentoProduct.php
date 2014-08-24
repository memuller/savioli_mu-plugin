<?php  
namespace Savioli;
class MagentoProduct {

	static function build(){
		
	} 
	static function build_database(){}

	static function all($url, $ammount = 1, $full = true){
		$products = get_transient('magento_products-'.$url);

		if(!$products){
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
			set_transient('magento_products-'.$url, $products, 60*60);
		}
		return array_slice($products, 0, $ammount);
	}

}

?>