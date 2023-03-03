<!--pour récupérer la partie header -->
<?php get_header() ?>

<main class="p-5">
    <div>
        <?php
            the_archive_title("<h4>","</h4>");
            the_archive_description("<em>","</em>");

        ?>
    </div>
    <div class="row">
        <div class="col-sm-8 bloc-main bg-primary d-flex flex-row mb-3 flex-wrap justify-content-center">

            <!--            Partie pour le contenu principal-->
            <?php
            // si j'ai aumoins 1 article je loop dessus pour récupérer chaque article
            if(have_posts()) : while(have_posts()) : the_post();
                // on récupère content.php auquel on lui donne les infos de "the_post"
                get_template_part('content','category', get_post_format());
            endwhile;
            endif;

            ?>
        </div>
        <!--        on importe la sidebar-->
        <?php get_sidebar()  ?>
    </div>



</main>


<!--pour récupérer la partie footer -->
<?php get_footer() ?>