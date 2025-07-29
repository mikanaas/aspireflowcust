<?php
/*
Plugin Name: Aspireflow Forsidevisning
Description: Viser innholdet fra en spesifikk side (ID 2826) som forsiden på aspireflow.no uten å vise /aspireflow i URL.
Version: 1.0
Author: Kim
*/

add_action('template_redirect', function () {
    error_log('🔍 KJØRER template_redirect');

    $host = $_SERVER['HTTP_HOST'] ?? '';
    $uri = $_SERVER['REQUEST_URI'] ?? '';

    error_log('📍 Host: ' . $host);
    error_log('📍 URI: ' . $uri);

    if (
        ($host === 'aspireflow.no' || $host === 'www.aspireflow.no') &&
        ($uri === '/' || $uri === '/index.php')
    ) {
        error_log('✅ Treffer riktig domenenavn og URI');

        $page_id = 2826;
        $page = get_post($page_id);

        if ($page) {
            error_log('📄 Fant side med ID 2826, status: ' . $page->post_status);

            if ($page->post_status === 'publish') {
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

                error_log('🚀 Laster side-mal...');
                include get_page_template();
                exit;
            } else {
                error_log('⛔ Side 2826 er ikke publisert');
            }
        } else {
            error_log('⛔ Fant ikke side med ID 2826');
        }
    } else {
        error_log('⛔ Domenet eller URI samsvarer ikke – ignorerer');
    }
});
