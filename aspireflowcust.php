<?php
/*
Plugin Name: Aspireflow Forsidevisning
Description: Viser innholdet fra en spesifikk side (ID 2826) som forsiden på aspireflow.no uten å vise /aspireflow i URL.
Version: 1.0
Author: Kim
*/

add_action('template_redirect', function () {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $uri = $_SERVER['REQUEST_URI'] ?? '';

    if (
        ($host === 'aspireflow.no' || $host === 'www.aspireflow.no') &&
        ($uri === '/' || $uri === '/index.php')
    ) {
        $page_id = 2826;
        $page = get_post($page_id);

        if ($page && $page->post_status === 'publish') {
            global $post, $wp_query;

            $post = $page;
            $wp_query->post = $page;
            $wp_query->queried_object = $page;
            $wp_query->queried_object_id = $page_id;
            $wp_query->is_page = true;
            $wp_query->is_singular = true;
            $wp_query->is_home = false;
            $wp_query->is_front_page = true;
            $wp_query->is_404 = false;

            setup_postdata($post);

            // VIS DIVI-BYGGET SIDEINNHOLD DIREKTE
            get_header();
            echo apply_filters('the_content', $post->post_content);
            get_footer();
            exit;
        }
    }
});
