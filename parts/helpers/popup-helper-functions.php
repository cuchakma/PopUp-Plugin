<?php
class Popup_Helper{
    public static function PagesPostsIDTitle(){
        $post_pags_ids_title = array();
        $args2 = array(
            'post_type'   => array('post', 'page'),
            'post_status' => 'any',
            'order'       => 'ASC',
            'posts_per_page' => -1
        );
        $query2 = new WP_Query($args2);
        foreach($query2->posts as $post) {
            $post_pags_ids_title[$post->ID] = $post->post_title;
        }
        return $post_pags_ids_title;
    }
}

