<?php
/**
 * Plugin Name: Popup-Creator-Dev
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

final class Popup_init{
    
    public function __construct()
    {
        $this->initialize_constants();
        $this->script_classes();
        $this->functionality_classes();
    }

    public function initialize_constants() {
        define( 'BASEPATH', plugins_url( '', __FILE__ ) );
        define( 'BASEDIREC', __DIR__ );
        
    }

    public function script_classes() {
        require BASEDIREC . '/assets/class-assets.php';
    }

    public function functionality_classes() {
        require BASEDIREC . '/includes/helpers/popup-helper-functions.php';
        require BASEDIREC . '/includes/admin/class-popup-cpt.php';
        require BASEDIREC . '/includes/admin/class-popup-admin.php';
        require BASEDIREC . '/includes/public/class-popup-template.php';
    }
}

new Popup_init();
