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
        // Overstyr til riktig side
        $query->set('page_id', 2826);

        // Fortell WP at dette er en vanlig side, ikke standard forside
        $query->is_page = true;
        $query->is_singular = true;
        $query->is_home = false;
        $query->is_front_page = true;
    }
});
