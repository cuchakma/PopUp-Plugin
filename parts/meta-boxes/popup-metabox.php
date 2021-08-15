<?php
class PopupMetaboxes{

    public function __construct()
    {
        add_action('add_meta_boxes', array( $this, 'metabox_1' ) );
        add_action('save_post_popup', array( $this, 'save_popup_data'), 10, 1 );
    }

    public function metabox_1(){
        add_meta_box('popup-metabox-1', 'Popup Settings', array($this, 'render_metabox_1'), 'popup' );
    }

    public function render_metabox_1() {
        wp_enqueue_style('metabox-custom-css');
        $datas          = get_post_meta( get_the_ID(), 'popup_datas', true );
        $datas          = json_decode( $datas, true );
        $popup_active   = !empty( $datas['popup_active'] ) ? 'checked' : ''; 
        $popup_time     = isset( $datas['popup_time'] ) ? $datas['popup_time'] : '';
        $popup_url      = isset( $datas['popup_url'] ) ? $datas['popup_url'] : '';
        $popup_autohide = !empty( $datas['popup_autohide'] ) ? 'checked' : '';
        $popup_unhide   = !empty( $datas['popup_unhide'] )  ? 'checked' : '';
        $popup_size     = isset( $datas['popup_size'] ) ? $datas['popup_size'] : '';
        ?> 
        <div class="metabox-main">
            <div class="metabox-6">
                <h4>Active</h4>
                <input type="checkbox" id="popup_active" name="popup_active" value="1" <?php echo esc_attr($popup_active); ?>>
                <label for="popup_active">Active</label><br>
            </div>
            <div class="metabox-1">
                <h4>Display Popup After</h4>
                <input type="text" name="display_popup_after" value="<?php echo esc_attr($popup_time); ?>">
            </div>
            <div class="metabox-2">
                <h4>URL</h4>
                <input type="url" name="popup_url" value="<?php echo esc_url($popup_url); ?>">
            </div>
            <div class="metabox-3">
                <h4>Auto Hide</h4>
                <input type="checkbox" id="auto_hide" name="auto_hide" value="1" <?php echo esc_attr($popup_autohide); ?>>
                <label for="auto_hide">Don't Hide</label><br>
            </div>
            <div class="metabox-4">
                <h4>Display On Exit</h4>
                <input type="checkbox" id="popup_dont_hide" name="popup_dont_hide" value="1"<?php echo esc_attr($popup_unhide); ?>>
                <label for="popup_dont_hide">Display On Exit</label><br>
            </div>
            <div class="metabox-5">
                <h4>Popup Size</h4>
                <select name="popup_size" id="popup_size">
                    <option disabled selected value> -- select an option -- </option>
                    <option value="popup-landscape"<?php echo $popup_size == 'popup-landscape'? 'selected' : '';?>>Landscape</option>
                    <option value="popup-square" <?php echo $popup_size == 'popup-square'? 'selected' : '';?>>Square</option>
                    <option value="original" <?php echo $popup_size == 'original'? 'selected' : '';?>>Original</option>
                </select>
            </div>
        </div>
        <?php
    }

    public function save_popup_data( $post_id ){
        $popup_active   = isset( $_POST['popup_active'] ) ? sanitize_text_field( $_POST['popup_active'] ) : '';
        $popup_time     = isset( $_POST['display_popup_after'] ) ? sanitize_text_field( $_POST['display_popup_after'] ) : '';
        $popup_url      = isset( $_POST['popup_url'] ) ? filter_var( $_POST['popup_url'], FILTER_SANITIZE_URL ) : '';
        $popup_autohide = isset( $_POST['auto_hide'] ) ? sanitize_text_field( $_POST['auto_hide'] ) : '';
        $popup_unhide   = isset( $_POST['popup_dont_hide'] ) ? sanitize_text_field(  $_POST['popup_dont_hide'] ) : '';
        $popup_size     = isset( $_POST['popup_size'] ) ? sanitize_text_field( $_POST['popup_size'] ) : '';
        $all_values     = json_encode(array( 'popup_active' => $popup_active, 'popup_time' => $popup_time, 'popup_url' => $popup_url, 'popup_autohide' => $popup_autohide, 'popup_unhide' => $popup_unhide, 'popup_size' => $popup_size));
        update_post_meta($post_id, 'popup_datas', $all_values);
    }
}

new PopupMetaboxes();