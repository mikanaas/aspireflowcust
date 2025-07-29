<?php
/*
Plugin Name: Aspireflow Forsidevisning
Description: Viser innholdet fra en spesifikk side (ID 2826) som forsiden på aspireflow.no uten å vise /aspireflow i URL.
Version: 1.0
Author: Kim
*/

add_action('template_redirect', function () {
    // Gjelder kun aspireflow.no sin forside
    if (
        isset($_SERVER['HTTP_HOST']) &&
        ($_SERVER['HTTP_HOST'] === 'aspireflow.no' || $_SERVER['HTTP_HOST'] === 'www.aspireflow.no') &&
        $_SERVER['REQUEST_URI'] === '/'
    ) {
        $page_id = 2826; // Bytt til riktig ID om nødvendig

        $page = get_post($page_id);

        if ($page && $page->post_status === 'publish') {
            global $post, $wp_query;

            // Fortell WordPress at vi viser denne siden
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

            // Bruk riktig mal
            include(get_page_template());
            exit;
        }
    }
});
