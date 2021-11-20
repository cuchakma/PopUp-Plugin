<?php

class Text_Widget extends Base_Widget {

    /**
     * Primary Constructor For The Widget
     */
    public function init() {
        $this->widget_type      = 'text';
        $this->widget_name      = "Text Field Widget";
        $this->widget_icon      = 'dashicons-welcome-learn-more';
        $this->widget_priority  = 1;
        $this->widget_id        = 1;
    }

    public function render_widget_preview() {

    }
}

new Text_Widget();