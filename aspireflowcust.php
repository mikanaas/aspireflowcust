<?php
/*
Plugin Name: Aspireflow Forsidevisning
Description: Viser innholdet fra en spesifikk side (ID 2826) som forsiden på aspireflow.no uten å vise /aspireflow i URL.
Version: 1.0
Author: Kim
*/

add_action('pre_get_posts', function ($query) {
    if (
        !is_admin() &&
        $query->is_main_query() &&
        isset($_SERVER['HTTP_HOST']) &&
        ($_SERVER['HTTP_HOST'] === 'aspireflow.no' || $_SERVER['HTTP_HOST'] === 'www.aspireflow.no') &&
        $query->is_front_page()
    ) {
        $page = get_page_by_path('aspireflow'); // sluggen
        if ($page) {
            $query->set('page_id', $page->ID);
            $query->is_page = true;
            $query->is_singular = true;
            $query->is_home = false;
            $query->is_front_page = true;
        }
    }
});
