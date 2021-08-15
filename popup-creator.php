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
        $args = array(
            'post_type'   => 'popup',
            'post_status' => 'publish',
            'meta_key'    => 'popup_datas'
        );
        $query = new WP_Query($args);
        while($query->have_posts()) {
            $query->the_post();
            $size = json_decode(get_post_meta(get_the_ID(), 'popup_datas', true));
            if($size->popup_active) {
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size->popup_size);
                ?>
                    <div class="modal-content" data-modal-id="<?php the_ID(); ?>" data-size="<?php echo  $size->popup_size; ?>">
                    <img src="<?php echo esc_url($image[0]);?>" height="<?php echo $image[1]; ?>" width="<?php echo $image[2];?>">
                        <div>
                            <img class="close-button" alt="close-img" width="40" src="<?php echo plugins_url('', __FILE__).'/assets/img/close.png';?>">
                        </div>
                    </div>
                <?php
            }
        }
        wp_reset_query();
    }
}

new PopupCreator();