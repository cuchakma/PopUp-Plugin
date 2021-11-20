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
     *  Widget Type
     * 
     *  @var string
     */
    public $widget_type;

    /**
     * Auto Initialize The Base Widget Template
     */
    public function __construct() {
        $this->init();
        add_action( 'popup_widgets_hook_admin', array( $this, 'send_widget_details' ), 10, 1 );
    }

    abstract public function init();

    abstract public function render_widget_preview();

    public function send_widget_details($widget_fields) {
        $widget_fields = array(
            $this->widget_type => array(
            'widget_name'     => $this->widget_name,
            'widget_icon'     => $this->widget_icon,
            'widget_priority' => $this->widget_priority,
            'widget_id'       => $this->widget_id
            ) 
        );

        return $widget_fields;
    }
}