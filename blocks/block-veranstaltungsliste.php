<ul class="veranstaltungsliste">

    <?php
    $order = 'ASC';
    if (block_field('reihenfolge-umkehren', false)) {
        $order = 'DESC';
    }
    ?>

    <?php
    $loop = new WP_Query(
        array(
            'post_type' => 'veranstaltung',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_key' => 'startdatum',
            'orderby' => 'meta_value_num',
            'meta_type' => 'DATE',
            'order' => $order
        )
    );
    ?>

    <?php $count = 0; ?>
    <?php while ($loop->have_posts()) : $loop->the_post(); ?>

        <?php $id = get_the_ID(); ?>

        <?php if ($count < block_field('maximal-angezeigte-veranstaltungen', false)) { ?>

            <?php
            if (
                block_field('zeige-vergangene-veranstaltungen', false) == is_vergangene_veranstaltung($id)
                or block_field('zeige-laufende-veranstaltungen', false) == is_laufende_veranstaltung($id)
                or block_field('zeige-zukunftige-veranstaltungen', false) == is_zukunftige_veranstaltung($id)
            ) {
            ?>
                <a href="<?php echo get_permalink(); ?>">
                    <li class="veranstaltungsliste-item">
                        <h4><?php the_title(); ?></h4>
                        <p><?php echo get_veranstaltung_datum($id); ?></p>
                        <?php echo get_veranstaltung_bild($id); ?>
                    </li>
                </a>

                <?php $count++; ?>
        <?php
            }
        }
        ?>
    <?php
    endwhile;
    wp_reset_query();
    ?>

</ul>

<?php
if ($count == 0) {
    echo '<p>' . block_field('keine-veranstaltungen-info', false) . '</p>';
}
?>