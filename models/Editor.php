<?php
	namespace Savioli;
	use CustomUser, DateTime ;

	class Editor extends CustomUser  {

		static $name = 'editor' ;

		static $fields = array(
			'avatar' => array('type' => 'media', 'label' => 'Avatar')
		);

		static $allow_admin = true;

		static function auth(){
			wp_die( "You can only edit a Corporation if you're it's lead member. Please contact us if you believe you should be able to do so.", "Corporate owners only" );
		}


		static function build(){
			parent::build();

		}


	}

 ?>