<?php

class Popup_template {

    public function __construct()
    {
        add_action( 'wp_footer', array( $this, 'print_popup_markup') );
    }

    public function print_popup_markup(){
        $current_page         = get_queried_object();
        $current_page_id      = isset( $current_page->ID ) ? $current_page->ID : '';
        $get_meta_datas       = get_post_meta($current_page_id, 'popup_id');
        $get_meta_datas       = is_bool( $get_meta_datas ) ? array() : $get_meta_datas;
        $make_metadata_single = !empty(array_column($get_meta_datas, 'popup_id')[0]) ? array_column($get_meta_datas, 'popup_id')[0] : array();
        foreach($make_metadata_single as $id) {
            $popup_datas_to_array = \json_decode(get_post_meta($id, 'popup_datas', true), true);
            if( $popup_datas_to_array['popup_active'] ) {
                $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), $popup_datas_to_array['popup_size'] );
                ?>
                    <div class="modal-content" data-modal-id="<?php the_ID(); ?>" data-size="<?php echo $popup_datas_to_array['popup_size']; ?>">
                    <img src="<?php echo esc_url($image_src[0]);?>" height="<?php echo $image_src[1]; ?>" width="<?php echo $image_src[2];?>">
                        <div>
                            <img class="close-button" alt="close-img" width="40" src="<?php echo BASEPATH.'/assets/images/close.png';?>">
                        </div>
                    </div>
                <?php
            }
        }
    }


}

new Popup_template();