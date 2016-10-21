<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function startbootstrap_preprocess_page(&$variables) {
    $main_menu = variable_get('menu_main_links_source', 'main-menu');
    $menu_r = menu_build_tree($main_menu);
    $variables['main_menu'] = html_main_menu($menu_r);

    $header = drupal_get_http_header('status');
    if ($header == '404 Not Found') {
        $variables['theme_hook_suggestions'][] = 'page__404';
    }
}

function html_main_menu($menu_r) {
    $html = '';
    foreach ($menu_r as $value) {
        $link_title = $value['link']['link_title'];
        $html .= '<li>' . '<a class="page-scroll" href="#' . $link_title . '">' . $link_title . '</a></li>';
    }

    return $html;
}

function get_link_path($link_path) {
    return $link_path == '<front>' ? '' : drupal_get_path_alias($link_path);
}

function startbootstrap_user_profile(&$variables) {
    $account = $variables['elements']['#account'];

    // Helpful $user_profile variable for templates.
    foreach (element_children($variables['elements']) as $key) {
        $variables['user_profile'][$key] = $variables['elements'][$key];
    }

    // Preprocess fields.
    field_attach_preprocess('user', $account, $variables['elements'], $variables);
}
