<!--Nous avons accès ici aux valeurs renvoyées par "the_post"-->
<!--the_title()-->
<!--the_content()-->



<div class="card border-bottom border-primary m-3" style="width: 18rem;">
    <img src="<?php the_post_thumbnail_url(); ?>" class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title"><?php the_title() ?></h5>
        <p class="card-text"> <?php the_date() ?> par <a class="text-white " href=""> <?php the_author()  ?> </a> </p>
        <p class="card-text"><?php the_excerpt(); ?></p>
        <a href="<?php the_permalink(); ?>" class="btn btn-primary">Voir plus</a>
    </div>



</div>
