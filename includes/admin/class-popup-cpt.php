<?php 

class Popup_cpt{

    public function __construct()
    {
        add_action( 'init', array( $this, 'register_cpt_popup' ) );
    }

    public function register_cpt_popup(){
        $labels = array(
            'name'               => 'Popups',
            'singular_name'      => 'Popup',
            'featured_image'     => 'Popup Image',
            'set_featured_image' => 'Set Popup Image'
        );

        $args = array(
            'label'                 => 'Popups',
            'labels'                => $labels,
            'description'           => '',
            'menu_icon'             => BASEPATH.'/assets/images/pop-up.png',
            'public'                => false,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'delete_with_user'      => false,
            'show_in_rest'          => true,
            'has_archive'           => false,
            'show_in_menu'          => true,
            'show_in_nav_menus'     => false,
            'exclude_from_search'   => true,
            'capability_type'       => 'post',
            'map_meta_cap'          => true,
            'hierarchical'          => false,
            'rewrite'               => array('slug' => 'popup', 'with_front' => true),
            'query_var'             => true,
            'supports'              => array("title", "thumbnail")
        );

        register_post_type('popup', $args);
    }
}

new Popup_cpt();