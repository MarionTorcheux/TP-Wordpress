<!--pour récupérer la partie header -->
<?php get_header() ?>



<main>

    <?php
        if (have_posts()) : while (have_posts()) : the_post();
            // Vérifier si nous sommes sur une page de produit WooCommerce
            if (function_exists('is_product') && is_product()) {
    ?>

              <h2><?php woocommerce_template_single_title(); ?></h2>

               <div><?php the_content(); ?></div>

                <?php
            } else {
                // Si ce n'est pas une page de produit, afficher le contenu de l'article
                get_template_part('content', get_post_format());
            }
                endwhile; endif;
    ?>

</main>


<!--pour récupérer la partie footer -->
<?php get_footer() ?>