<?php

function str_replace_first($from, $to, $content)
{
    $from = '/' . preg_quote($from, '/') . '/';

    return preg_replace($from, $to, $content, 1);
}

add_filter('jpeg_quality', function ($arg) {
    return 80;
});

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype($output)
{
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');


function tanketheme_widgets_init()
{
    register_sidebar(array(
        'name'          => 'Header Intro',
        'id'            => 'header-intro_widget',
    ));
    register_sidebar(array(
        'name'          => 'Row A',
        'id'            => 'row-a_widget',
    ));
    register_sidebar(array(
        'name'          => 'Row B',
        'id'            => 'row-b_widget',
    ));
    register_sidebar(array(
        'name'          => 'Row C',
        'id'            => 'row-c_widget',
    ));
}
add_action('widgets_init', 'tanketheme_widgets_init');

add_theme_support('post-thumbnails');


function date_to_str(DateTime $date, string $format)
{
    return date_i18n($format, $date->getTimestamp());
}

function get_nachste_veranstaltung(int $id): WP_Post
{
    $currentPostDate = date_create(get_post_meta($id, 'startdatum', true));

    $args =  array(
        'post_type' => 'veranstaltung',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'meta_key' => 'startdatum',
        'meta_compare' => '>=',
        'meta_value' => $currentPostDate,
        'meta_type' => 'DATE',
    );

    return query_posts($args);
}

function is_zukunftige_veranstaltung(int $id): bool
{
    $startdatum = date_create(get_post_meta($id, 'startdatum', true));
    $vernissagedatum_und_zeit = date_create(get_post_meta($id, 'vernissagedatum_und_zeit', true));

    $now = new DateTime();
    $earliest = min(array($startdatum, $vernissagedatum_und_zeit));

    return $now <= $earliest;
}

function is_laufende_veranstaltung(int $id): bool
{
    $startdatum = date_create(get_post_meta($id, 'startdatum', true));
    $enddatum = date_create(get_post_meta($id, 'enddatum', true));
    $vernissagedatum_und_zeit = date_create(get_post_meta($id, 'vernissagedatum_und_zeit', true));
    $finissagedatum_und_zeit = date_create(get_post_meta($id, 'finissagedatum_und_zeit', true));

    $now = new DateTime();
    $earliest = min(array($startdatum, $vernissagedatum_und_zeit));
    $latest = max(array($startdatum, $enddatum, $vernissagedatum_und_zeit, $finissagedatum_und_zeit));

    return $now <= $latest && $now >= $earliest;
}

function is_vergangene_veranstaltung(int $id): bool
{
    $startdatum = date_create(get_post_meta($id, 'startdatum', true));
    $enddatum = date_create(get_post_meta($id, 'enddatum', true));
    $vernissagedatum_und_zeit = date_create(get_post_meta($id, 'vernissagedatum_und_zeit', true));
    $finissagedatum_und_zeit = date_create(get_post_meta($id, 'finissagedatum_und_zeit', true));

    $now = new DateTime();
    $latest = max(array($startdatum, $enddatum, $vernissagedatum_und_zeit, $finissagedatum_und_zeit));

    return $now > $latest;
}

function get_veranstaltung_datum(int $id): string
{
    $mehrere_tage = (bool) get_post_meta($id, 'mehrere_tage', true);
    $startdatum = date_create(get_post_meta($id, 'startdatum', true));
    $enddatum = date_create(get_post_meta($id, 'enddatum', true));
    $ganztagig = (bool) get_post_meta($id, 'ganztagig', true);
    $startzeit = date_create(get_post_meta($id, 'startzeit', true));
    $endzeit = date_create(get_post_meta($id, 'endzeit', true));
    $vernissage = (bool) get_post_meta($id, 'vernissage', true);
    $vernissagedatum_und_zeit = date_create(get_post_meta($id, 'vernissagedatum_und_zeit', true));
    $fi­nis­sa­ge = (bool) get_post_meta($id, 'fi­nis­sa­ge', true);
    $finissagedatum_und_zeit = date_create(get_post_meta($id, 'finissagedatum_und_zeit', true));
    $alle_wochentage = (bool) get_post_meta($id, 'alle_wochentage', true);
    $wochentage = get_post_meta($id, 'wochentage', true);

    $date_string = '';

    if ($mehrere_tage) {
        if (date_format($startdatum, 'Y') == date_format($enddatum, 'Y')) {
            if (date_format($startdatum, 'm') == date_format($enddatum, 'm')) {
                $date_string .= date_to_str($startdatum, 'd.') . ' – ' . date_to_str($enddatum, 'd. F Y');
            } else {
                $date_string .= date_to_str($startdatum, 'd. F') . ' – ' . date_to_str($enddatum, 'd. F Y');
            }
        } else {
            $date_string .= date_to_str($startdatum, 'd. F Y') . ' – ' . date_to_str($enddatum, 'd. F Y');
        }

        if (!$alle_wochentage) {
            $date_string .= '<br />' . $wochentage;
        }
    } else {
        $date_string .= date_to_str($startdatum, 'd. F Y',);
    }

    if (!$ganztagig) {
        $date_string .= ' / ' . date_to_str($startzeit, 'G:i') . ' – ' . date_to_str($endzeit, 'G:i') . ' Uhr';
    }

    if ($vernissage) {
        $date_string .= '<br />Vernissage: ' . date_to_str($vernissagedatum_und_zeit, 'd. F \u\m G:i') . ' Uhr';
    }

    if ($fi­nis­sa­ge) {
        $date_string .= '<br />Finissage: ' . date_to_str($finissagedatum_und_zeit, 'd. F G:i') . ' Uhr';
    }

    return $date_string;
}

function get_veranstaltung_bild_url(int $id): string
{
    if (get_post_meta($id, 'veranstaltungsbild', true)) {
        $veranstaltungsbild = get_post_meta($id, 'veranstaltungsbild', true);
        return wp_get_attachment_image_src($veranstaltungsbild, 'large')[0];
    } else {
        return '';
    }
}

function get_veranstaltung_bild(int $id): string
{
    $bild = (bool) get_post_meta($id, 'bild', true);
    $bild_untertitel = get_post_meta($id, 'bild_untertitel', true);

    if (!$bild) {
        return '';
    }

    $bild_str = '<div>';

    $image_url = get_veranstaltung_bild_url($id);

    $bild_str .= '<img src="' . $image_url . '" style="width: 100%;" />';
    $bild_str .= '<p>' . $bild_untertitel  . '</p>';

    $bild_str .= '</div>';
    return $bild_str;
}
