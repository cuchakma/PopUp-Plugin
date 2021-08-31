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

use function GuzzleHttp\json_decode;

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

class PopupCreator{

    public function __construct()
    {
        add_action( 'init', array( $this, 'register_cpt_popup' ) );
        add_action( 'init', array( $this, 'register_popup_size') );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_side_style') );
        add_action( 'wp_enqueue_scripts', array( $this, 'public_side_scripts') );
        add_action( 'wp_footer', array( $this, 'print_modal_markup') );
        require __DIR__.'/parts/helpers/popup-helper-functions.php';
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
        add_image_size('popup-landscape', 800, 600, true);
        add_image_size('popup-square', 500, 500);
    }

    public function print_modal_markup(){
        $current_page         = get_queried_object();
        $current_page_id      = isset( $current_page->ID ) ? $current_page->ID : '';
        $get_meta_datas       = get_post_meta($current_page_id, 'popup_id');
        $get_meta_datas       = is_bool( $get_meta_datas ) ? array() : $get_meta_datas;
        $make_metadata_single = !empty(array_column($get_meta_datas, 'popup_id')[0]) ? array_column($get_meta_datas, 'popup_id')[0] : array();
        foreach($make_metadata_single as $id) {
            $popup_datas_to_array = \json_decode(get_post_meta($id, 'popup_datas', true), true);
            if( $popup_datas_to_array['popup_active'] ) {
                $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), $popup_datas_to_array['popup_size'] );
                ?>
                    <div class="modal-content" data-modal-id="<?php the_ID(); ?>" data-size="<?php echo $popup_datas_to_array['popup_size']; ?>">
                    <img src="<?php echo esc_url($image_src[0]);?>" height="<?php echo $image_src[1]; ?>" width="<?php echo $image_src[2];?>">
                        <div>
                            <img class="close-button" alt="close-img" width="40" src="<?php echo plugins_url('', __FILE__).'/assets/img/close.png';?>">
                        </div>
                    </div>
                <?php
            }
        }
    }
}

new PopupCreator();