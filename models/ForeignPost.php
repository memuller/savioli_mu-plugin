<?php  
namespace Savioli;
use BaseItem ;
class ForeignPost extends BaseItem {

	static function build(){} 
	static function build_database(){}

	static function all($blog=1){
		$options = get_option('clinica-savioli_options');
		$blogs = $options['blogs'];
		
		switch_to_blog($blogs["$blog"]);
		$posts = get_posts(array(
			'posts_per_page' => $options['blogs_num_posts']
		));
		restore_current_blog(); 
		
		return $posts ; 
	}

	public function user_avatar($size=96){
		return get_avatar($this->post_author, $size);
	}

	

}

?>