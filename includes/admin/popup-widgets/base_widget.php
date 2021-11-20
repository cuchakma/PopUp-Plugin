<?php
/**
 * Base Field Template For Popup Widget
 */
abstract class Base_Widget{

    /**
     * Name Of The Widget (e.g: "Accordion", "Text Field")
     *
     * @var string
     */
    public $widget_name;

    /**
     * Font Awsome Icon For Widget
     *
     * @var string
     */
    public $widget_icon;

    /**
     * Priority Of The Widget (e.g: 10, 9, 8, etc)
     *
     * @var int
     */
    public $widget_priority;

    /**
     * Auto Created ID Of The Widget
     *
     * @var int
     */
    public $widget_id;

    /**
     * Auto Initialize The Base Widget Template
     */
    public function __construct() {
        $this->init();
        add_action('popup_widgets_hook_admin', array( $this, 'render_widget_preview' ), 10 );
    }

    abstract public function init();

    abstract public function render_widget_preview();
}