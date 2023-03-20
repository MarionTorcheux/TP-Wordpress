<!--pour récupérer la partie header -->
<?php get_header() ?>


<main>
    <div class="row flex-page">
        <div class="col-sm-8 bloc-main d-flex flex-row mb-3 flex-wrap page-content ">

            <!--            Partie pour le contenu principal-->
            <?php
            // si j'ai aumoins 1 article je loop dessus pour récupérer chaque article
            if(have_posts()) : while(have_posts()) : the_post();
                // on récupère content.php auquel on lui donne les infos de "the_post"
                get_template_part('content', 'page', get_post_format());
            endwhile;
            endif;

            ?>
        </div>

        <?php
        if (is_page("Qu'est ce que le modélisme ?")){
            get_sidebar();
        }



        ?>
    </div>
</main>


<!--pour récupérer la partie footer -->
<?php get_footer() ?>