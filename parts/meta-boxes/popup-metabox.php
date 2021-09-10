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
        $selected_pages = get_post_meta(get_the_ID(), 'popup_pages_selected', true);
        $selected_pages = !empty($selected_pages) ? $selected_pages : array();
        ?> 
        <div class="colums">
            <div class="item">
                <h4>Active</h4>
                <input type="checkbox" id="popup_active" name="popup_active" value="1" <?php echo esc_attr($popup_active); ?>>
                <label for="popup_active">Active</label><br>
            </div>
            <div class="item">
                <h4>Display Popup After</h4>
                <input type="text" name="display_popup_after" value="<?php echo esc_attr($popup_time); ?>">
            </div>
            <div class="item">
                <h4>URL</h4>
                <input type="url" name="popup_url" value="<?php echo esc_url($popup_url); ?>">
            </div>
            <div class="item">
                <h4>Auto Hide</h4>
                <input type="checkbox" id="auto_hide" name="auto_hide" value="1" <?php echo esc_attr($popup_autohide); ?>>
                <label for="auto_hide">Don't Hide</label><br>
            </div>
            <div class="item">
                <h4>Display On Exit</h4>
                <input type="checkbox" id="popup_dont_hide" name="popup_dont_hide" value="1"<?php echo esc_attr($popup_unhide); ?>>
                <label for="popup_dont_hide">Display On Exit</label><br>
            </div>
            <div class="item">
                <h4>Popup Size</h4>
                <select name="popup_size" id="popup_size">
                    <option disabled selected value> -- select an option -- </option>
                    <option value="popup-landscape"<?php echo $popup_size == 'popup-landscape'? 'selected' : '';?>>Landscape</option>
                    <option value="popup-square" <?php echo $popup_size == 'popup-square'? 'selected' : '';?>>Square</option>
                    <option value="original" <?php echo $popup_size == 'original'? 'selected' : '';?>>Original</option>
                </select>
            </div>
            <div class="item">
                <h4>Select Pages To Target</h4>
                <select name="popup_page_ids[]" id="popup_page_ids" multiple>
                    <option disabled selected value> -- select an option -- </option>
                    <?php 
                        foreach(Popup_Helper::PagesPostsIDTitle() as $page_id => $page_title) {
                            ?>
                                <option value="<?php echo $page_id;?>" <?php echo in_array($page_id, $selected_pages) ? 'selected':'';?>><?php echo $page_title; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
            <div class="item">
                <h4>Select To Unassign Current Popup</h4>
                <select name= "selected_pages[]" id="selected_pages" multiple>
                    <option disabled selected value>--Pages Selected--</option>
                    <?php 
                        foreach(Popup_Helper::PagesPostsIDTitle() as $page_id => $page_title) {
                            if( in_array( $page_id, $selected_pages ) ) {
                                ?>
                                    <option value="<?php echo $page_id;?>"><?php echo $page_title; ?></option>
                                <?php
                            }
                        }
                    ?>
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

        //pages ID values from user input
        $popup_page_ids       = !empty( $_POST['popup_page_ids'] ) ? $_POST['popup_page_ids'] : '';
        update_post_meta($post_id, 'popup_pages_selected', $popup_page_ids);

        //assigning popup ID's to page ID's
        if(!empty($popup_page_ids)) {
            foreach( $popup_page_ids as $page_id ) {
                $get_previous_popup_ids = get_post_meta($page_id, 'popup_id', true); //get previous popup ID, on page ID
                //delete if the previous pop up id is not array
                if(!is_array($get_previous_popup_ids)) {
                    delete_post_meta($page_id, 'popup_id');
                    $get_previous_popup_ids = array();
                }
                if( !empty( $get_previous_popup_ids ) || $get_previous_popup_ids != null ) {
                    if( $get_previous_popup_ids['popup_id'] != null ) {
                        array_push($get_previous_popup_ids['popup_id'], $post_id );
                        $get_previous_popup_ids['popup_id'] = array_unique($get_previous_popup_ids['popup_id']);
                    }
                    update_post_meta($page_id, 'popup_id', $get_previous_popup_ids);
                } else {
                    $popup_ids = array('popup_id' => array( $post_id ) );
                    update_post_meta($page_id, 'popup_id', $popup_ids);
                }
            }
        }

        /**
         * Delete Popup Datas From Selected Fields/Pages
         */
        if( isset( $_POST['selected_pages'] ) ) {
            $get_selected_page_id        = get_post_meta($post_id, 'popup_pages_selected', true);
            $new_unselected_pages_id     = array_diff( $get_selected_page_id, $_POST['selected_pages'] );
            
            $page_ids_to_remove_popup = isset( $_POST['selected_pages'] ) ? $_POST['selected_pages'] : '';
            foreach( $page_ids_to_remove_popup as $page_id ) {
                $get_popup_from_page_id     = get_post_meta($page_id, 'popup_id', true);
                $new_updated_popup_ids      = $get_popup_from_page_id['popup_id'];
                $delete_popup_index         = array_search(get_the_ID(), $new_updated_popup_ids);
                if( isset( $delete_popup_index ) ) {
                    unset( $new_updated_popup_ids[$delete_popup_index] );
                    $new_updated_popup_ids = array_values($new_updated_popup_ids);
                    update_post_meta($post_id, 'popup_pages_selected', $new_unselected_pages_id);
                    update_post_meta($page_id, 'popup_id', $new_updated_popup_ids);
                }
            }
        }
    }
}

new PopupMetaboxes();