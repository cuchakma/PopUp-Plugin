<?php

class Popup_Builder{
    public function __construct()
    {
        add_action('admin_menu', array( $this, 'popup_builder_menu' ) );
    }

    public function popup_builder_menu() {
        add_submenu_page(
            'edit.php?post_type=popup',
            ('Builder Mode'),
            ('Builder Mode'),
            'manage_options',
            'popup_builder_mode',
            array($this, 'builder_content'),
            1
        );
    }
    public function builder_content() {
        ?>
            <div class="popup-main-section">

                <aside class="popup-sidebar">

                    <h3 class="pop-wid-head">Popup Widget</h3>

                    <ul class="popup-text-widget">

                        <?php 
                            $popup_fields = '';
                            $field_data = apply_filters('popup_widgets_hook_admin', $popup_fields );
                            foreach( $field_data as $type => $data ) {
                                if( $type === 'text') {
                                    echo '<li class="popup_text_widget" data-id="'.$data['widget_id'].'"><span class="'.$data['widget_icon'].'">'.$data['widget_name'].'</span></li>';
                                }
                            }
                        ?>

                    </ul>

                </aside>

                <main class="popup-build">

                    <?php do_action('popup_preview_screen_admin'); ?>

                </main>

            </div>
            
        <?php
    }
}
new Popup_Builder();