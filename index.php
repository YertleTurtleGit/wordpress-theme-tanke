<?php get_header(); ?>


<div id="render-area"></div>

<script src="<?php echo get_bloginfo('template_directory');
                ?>/lib/three.min.js"></script>
<script src="<?php echo get_bloginfo('template_directory');
                ?>/lib/GLTFLoader.js"></script>
<script src="<?php echo get_bloginfo('template_directory');
                ?>/render.js"></script>

<div id="index-all">

    <div id='header'>
        <h1 id='header-logo'>
            Tanke</br>
            Tanke</br>
            Tanke</br>
            Tanke</br>
            Tanke
        </h1>
    </div>

    <div id='content-rows' style="position: absolute; top: 150%; left: 0; width: 100%; height: auto;">

        <div id="intro">
            <p style="word-break:normal;">Die TANKE ist ein Projektraum für Kunst.
                Hier arbeiten Künstler*innen und es finden verschiedene Veranstaltungen rund um die Kunst statt:
                Ausstellungen, Gespräche, Kunstfilmabende und Workshops. <a href="//tanke-hannover.de/wir-sind/">Mehr dazu...</a>
            </p>
            <p style="word-break:normal;">Hier kannst Du Dich für unseren <a href="//tanke-hannover.de/newsletter/">Newsletter</a> anmelden.</p>
        </div>

        <div id='row-a' class='content-row'>
            <?php if (is_active_sidebar('row-a_widget')) : ?>
                <?php dynamic_sidebar('row-a_widget'); ?>
            <?php endif; ?>
        </div>

        <div id='row-b' class='content-row'>
            <?php if (is_active_sidebar('row-b_widget')) : ?>
                <?php dynamic_sidebar('row-b_widget'); ?>
            <?php endif; ?>
        </div>

        <div id='row-c' class='content-row'>
            <?php if (is_active_sidebar('row-c_widget')) : ?>
                <?php dynamic_sidebar('row-c_widget'); ?>
            <?php endif; ?>
        </div>

    </div>

</div>

<?php get_footer(); ?>