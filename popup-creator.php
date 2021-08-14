<?php

/**
 * Plugin Name: Popup-Creator
 * Plugin URI:  www.facebook.com
 * Description: This plugin is used for creating popups
 * Version:     1.0.0
 * Author:      Cupid Chakma
 * Author URI:  www.facebook.com
 * Text Domain: popup-creator
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package     Popup-Creator
 * @author      Cupid Chakma
 * @copyright   2021 D&D
 * @license     GPL-2.0+
 *
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

class PopupCreator{

    public function __construct()
    {
        add_action( 'init', array( $this, 'register_cpt_popup' ) );
        add_action( 'init', array( $this, 'register_popup_size') );
        add_action('admin_enqueue_scripts', array( $this, 'admin_side_style') );
        require __DIR__.'/parts/meta-boxes/popup-metabox.php';
    }

    public function admin_side_style() {
        wp_register_style( 'metabox-custom-css', plugins_url('', __FILE__).'/assets/css/style.css', false, rand());
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

    public function register_popup_size() {
        add_image_size('popup-landscape', 600, 800, true);
    }
}

new PopupCreator();