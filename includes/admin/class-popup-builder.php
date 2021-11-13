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
                </aside>
                <main class="popup-build">
                    
                </main>
            </div>
        <?php
    }
}
new Popup_Builder();