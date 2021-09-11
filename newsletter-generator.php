<?php

/**
 * Template Name: Newsletter-Generator
 */
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TANKE Newsletter</title>

    <style>
        <?php echo file_get_contents(get_stylesheet_uri()); ?>

        /* */
        .newsletter-container {
            font-family: sans-serif;
            color: white;
            width: 800px;
            height: auto;
            background-color: #2e45a2;
            margin: 0px;
            padding: 10px;
            padding-left: 10%;
            padding-bottom: 50px;
        }

        .veranstaltungsliste {
            padding: 0;
        }

        .corona p {
            font-size: small;
        }

        p {
            max-width: 400px;
            color: white;
            hyphens: auto;
        }
    </style>
</head>

<body>

    <div class="newsletter-container">

        <h1>
            <br />
            TANKE<br />
            NEWSLETTER
        </h1>
        <p style="color: white; font-size: 14px">
            Wir nutzen keinerlei Tracking-Daten in unserem Newsletter.
        </p>
        <a style="color: pink; font-size: 14px" href="https://www.tanke-hannover.de">www.tanke-hannover.de</a>


        <ul class="veranstaltungsliste">

            <?php
            $loop = new WP_Query(
                array(
                    'post_type' => 'veranstaltung',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'meta_key' => 'startdatum',
                    'orderby' => 'meta_value_num',
                    'meta_type' => 'DATE',
                    'order' => 'ASC'
                )
            );
            ?>

            <?php $count = 0; ?>
            <?php while ($loop->have_posts()) : $loop->the_post(); ?>

                <?php $id = get_the_ID(); ?>

                <?php if ($count < 5) { ?>

                    <?php
                    if (!is_vergangene_veranstaltung($id)) {
                    ?>

                        <a href="<?php echo get_permalink(); ?>">
                            <li class="veranstaltungsliste-item">
                                <h4><?php the_title(); ?></h4>
                                <p><?php echo get_veranstaltung_datum($id); ?></p>
                                <?php echo get_veranstaltung_bild($id); ?>

                                <?php the_content(); ?>
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

        <div class="corona">
            <?php
            $sars_cov_2_block = get_post(1115);
            echo do_blocks($sars_cov_2_block->post_content);
            ?>
        </div>

    </div>

</body>

</html>