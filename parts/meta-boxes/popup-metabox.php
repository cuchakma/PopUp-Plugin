<?php
class PopupMetaboxes{

    public function __construct()
    {
        add_action('add_meta_boxes', array( $this, 'metabox_1' ) );
    }

    public function metabox_1(){
        add_meta_box('popup-metabox-1', 'Popup Settings', array($this, 'render_metabox_1'), 'popup' );
    }

    public function render_metabox_1() {
        wp_enqueue_style('metabox-custom-css');
        ?> 
        <div class="metabox-main">
            <div class="metabox-1">
                <h4>Display Popup After</h4>
                <input type="text" name="display_popup_after" value="">
            </div>
            <div class="metabox-2">
                <h4>URL</h4>
                <input type="url" name="popup_url" value="">
            </div>
            <div class="metabox-3">
                <h4>Auto Hide</h4>
                <input type="checkbox" id="auto_hide" name="auto_hide" value="">
                <label for="auto_hide">Don't Hide</label><br>
            </div>
            <div class="metabox-4">
                <h4>Display On Exit</h4>
                <input type="checkbox" id="dont_hide" name="dont_hide" value="">
                <label for="dont_hide">Display On Exit</label><br>
            </div>
        </div>
        <?php
    }
}

new PopupMetaboxes();