<?php
	namespace Savioli;
	use CustomUser, DateTime ;

	class Editor extends CustomUser  {

		static $name = 'editor' ;

		static $fields = array(
			'avatar' => array('type' => 'media', 'preview' => true, 'label' => 'Avatar')
		);

		static $allow_admin = true;

		static function auth(){
			wp_die( "You can only edit a Corporation if you're it's lead member. Please contact us if you believe you should be able to do so.", "Corporate owners only" );
		}


		static function build(){
			parent::build();
			add_filter('get_avatar', function($avatar, $id_or_email, $size, $default, $alt){
				$user = new \Savioli\Editor($id_or_email);
				if($user->avatar){
					$avatar = sprintf('<img class="avatar photo avatar-%s" 
						width="%s" height="%s" src="%s"></img>',$size, $size, $size, $user->avatar);
					
				}
				return $avatar;
			}, 10, 5);
		}


	}

 ?>