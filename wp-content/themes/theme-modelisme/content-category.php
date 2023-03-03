<!--template de rendu pour les catégories -->
<div class="m-3 col-sm-4 border p-2">
<div>
    <h3>
        <a class="text-white" href="<?php the_permalink(); ?>"> <?php  the_title(); ?> </a>
    </h3>

    <?php
        if('post'== get_post_type()): ?>

<!--        on vérifie s'il y a des posts liés à une catégorie -->
    <div class="blog-postmeta">
        <div class="post-date">
            <?php echo get_the_date(); ?>
        </div>
    </div>

    <?php endif; ?>

</div>

<div class="entry-summary ">
    <?php the_excerpt(); ?>
    <a class="text-white text-decoration-none" href="<?php the_permalink(); ?>">
        <?php  esc_html_e("&#10058; lire plus &#10058;");  ?>

    </a>
</div>

</div>