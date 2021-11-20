<?php

class Text_Widget extends Base_Widget {

    /**
     * Primary Constructor For The Widget
     */
    public function init() {
        $this->widget_name      = "Text Field Widget";
        $this->widget_icon      = 'dashicons-welcome-learn-more';
        $this->widget_priority  = 1;
        $this->widget_id        = 1;
    }

    public function render_widget_preview() {
        echo '<li class="popup_text_widget" data-id="'.$this->widget_id.'">';
        echo '<span class="'.$this->widget_icon.'">';
        echo $this->widget_name;
        echo '</span>';
        echo '<li>';
    }
}

new Text_Widget();