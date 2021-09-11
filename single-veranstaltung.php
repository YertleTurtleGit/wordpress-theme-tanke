<?php get_header(); ?>

<div id='all-container' style='margin-top: 0px;'>

    <div id='content'>

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="entry">
                    <div id='page-header'>
                        <a href='//tanke-hannover.de'>
                            <h4>TANKE</h4>
                        </a>
                        <h1 class='page-title'><?php the_title(); ?></h1>
                    </div>

                    <?php $id = get_the_ID(); ?>

                    <p><strong><?php echo get_veranstaltung_datum($id); ?></strong></p>

                    <?php
                    $sars_cov_2_block = get_post(1115);
                    echo do_blocks($sars_cov_2_block->post_content);
                    ?>

                    <?php echo get_veranstaltung_bild($id); ?>

                    <?php the_content(); ?>

                    <?php // print_r(get_nachste_veranstaltung($id)); 
                    ?>
                </div>
        <?php endwhile;
        endif; ?>

    </div>
</div>

<?php get_footer(); ?>