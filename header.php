<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta name="author" content="TANKE e.V. info@tanke-hannover.de">
    <meta name="title" content="TANKE e.V." />
    <meta name="description" content="Projektraum für Kunst" />

    <link href="<?php echo get_bloginfo('template_directory'); ?>/style.css" rel='stylesheet'>

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="48x48" href="favicon-48x48.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#2e45a2">
    <meta name="msapplication-TileColor" content="#2e45a2">
    <meta name="theme-color" content="#2e45a2">

    <?php if (is_singular() && pings_open()) { ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php
    }
    wp_head(); ?>

    <?php
    global $post;
    $id = $post->ID;

    if ($excerpt = $post->post_excerpt) {
        $excerpt = strip_tags($post->post_excerpt);
    } else {
        $excerpt = get_bloginfo('description');
    }

    $page_permalink = get_the_permalink();
    $page_title = 'TANKE ' . str_replace_first('TANKE', '', get_the_title());
    $page_name = get_bloginfo();
    $og_title = $page_title;
    ?>

    <title><?php echo $page_title; ?></title>

    <meta property="og:title" content="<?php echo $og_title; ?>" />
    <meta property="og:description" content="<?php echo $excerpt; ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?php echo $page_permalink; ?>" />
    <meta property="og:site_name" content="<?php echo $page_name; ?>" />

    <?php
    $image_url = "https://tanke-hannover.de/logo-og.png";

    if (get_post_type($id) == 'veranstaltung') {
        $image_url = get_veranstaltung_bild_url($id);
        if ($image_url == '') {
            $image_url = "https://tanke-hannover.de/logo-og.png";
        }
    }
    ?>

    <meta property="og:image" content="<?php echo $image_url; ?>" />
    <meta name="twitter:image" content="<?php echo $image_url; ?>" />

    <meta name="twitter:title" content="<?php echo $og_title; ?>" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="<?php echo $excerpt; ?>" />
    <meta name="twitter:url" content="<?php echo $page_permalink; ?>" />
</head>

<body <?php body_class(); ?>>

    <span id='impressum'>
        <a href='/datenschutz'>Datenschutz</a>
        <a href='/impressum'>Impressum</a>
    </span>