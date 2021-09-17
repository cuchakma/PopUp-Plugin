<?php

class Popup_assets {

    public function __construct()
    {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_side_style') );
        add_action( 'wp_enqueue_scripts', array( $this, 'public_side_scripts') );
    }

    public function admin_side_style() {
        wp_register_style( 'metabox-custom-css', BASEPATH.'/assets/css/style.css', false, rand());
    }

    public function public_side_scripts() {
        wp_enqueue_script( 'plainmodal-js', BASEPATH.'/assets/js/plain-modal.min.js', null, '1.0.34', true);
        wp_enqueue_style( 'popupcreator-css', BASEPATH.'/assets/css/modal.css', null, rand());
        wp_enqueue_script( 'popupcreator-main', BASEPATH.'/assets/js/popup-creator-main.js', array('jquery', 'plainmodal-js'), rand(), true);
    }

}

new Popup_assets();