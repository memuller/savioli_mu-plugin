<?php
  namespace Savioli ;
  use CustomPost, DateTime, DateInterval ;

  class Video extends CustomPost {

    static $name = "video" ;
    static $creation_fields = array(
      'label' => 'video','description' => 'Vídeo no Youtube.',
      'public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post', 'map_meta_cap' => true,
      'hierarchical' => false,'rewrite' => array('slug' => 'videos'),'query_var' => true,
      'supports' => array('custom-fields', 'title', 'thumbnail'),
      'has_archive' => true, 'taxonomies' => array(), 'menu_position' => 5
    ) ;
    static $labels = array (
      'name' => 'Vídeos',
      'singular_name' => 'Vídeo',
      'menu_name' => 'Vídeos',
      'add_new' => 'Adicionar novo',
      'add_new_item' => 'Adicionar novo vídeo',
      'edit' => 'Atualizar',
      'edit_item' => 'Atualizar vídeo',
      'new_item' => 'Registrar vídeo',
      'view' => 'Ver',
      'view_item' => 'Ver vídeo'
    );

    static $icon = '\f126' ;

    static $fields = array(
      'url' => array('label' => 'URL', 'description' => 'URL do vídeo no Youtube.', 'required' => true) 
    );

    static $editable_by = array(
      'Vídeo' => array('fields' => array('url', 'broadcast_date', 'travel', 'type'), 'placing' => 'normal')
    );

    static $collumns = array(
      'travel' => 'Viagem',
      'type_collumn' => 'Tipo'
    );

    public function type_collumn(){
      switch ($this->type) {
        case 'selected':
          echo 'Melhores Momentos';
          break;
        case 'complete':
          echo 'Programa Completo';
          break;
        default:
          echo '--';
          break;
      }
    }

    static function build(){
      $class = get_called_class();
      parent::build();
    }
  }

 ?>