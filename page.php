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

                    <?php the_content(); ?>
                </div>
        <?php endwhile;
        endif; ?>

    </div>
</div>

<?php get_footer(); ?>