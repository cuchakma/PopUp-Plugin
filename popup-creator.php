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
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_side_style') );
        add_action( 'wp_enqueue_scripts', array( $this, 'public_side_scripts') );
        add_action( 'wp_footer', array( $this, 'print_modal_markup') );
        require __DIR__.'/parts/meta-boxes/popup-metabox.php';
    }

    public function admin_side_style() {
        wp_register_style( 'metabox-custom-css', plugins_url('', __FILE__).'/assets/css/style.css', false, rand());
    }

    public function public_side_scripts() {
        wp_enqueue_script( 'plainmodal-js', plugins_url('', __FILE__).'/assets/js/plain-modal.min.js', null, '1.0.34', true);
        wp_enqueue_style( 'popupcreator-css', plugins_url('', __FILE__).'/assets/css/modal.css', null, rand());
        wp_enqueue_script( 'popupcreator-main', plugins_url('', __FILE__).'/assets/js/popup-creator-main.js', array('jquery', 'plainmodal-js'), rand(), true);
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
        add_image_size('popup-square', 500, 500);
    }

    public function print_modal_markup(){
        ?>
            <div id="modal-content" style="">
               <img src="https://images.unsplash.com/photo-1627662236973-4fd8358fa206?ixlib=rb-1.2.1&ixid=MnwxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1050&q=80" alt="image-popup" width="700" height="400">
                <div>
                    <img id="close-button" alt="close-img" width="40" src="<?php echo plugins_url('', __FILE__).'/assets/img/close.png';?>">
                </div>
            </div>

        <?php
    }
}

new PopupCreator();