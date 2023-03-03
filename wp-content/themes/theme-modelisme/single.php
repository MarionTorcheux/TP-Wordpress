<!--pour récupérer la partie header -->
<?php get_header() ?>

<main class="p-5">
    <div class="row">

        <div class="col-sm-8 bloc-main d-flex flex-row mb-3 flex-wrap single-content">
            <h2 class="title-product"><?php the_title() ?></h2>

            <div class="card" style="max-width: 1000px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid rounded-start" >
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php the_title() ?></h5>
                            <p class="card-text">   <?php the_content() ?> </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



</main>


<!--pour récupérer la partie footer -->
<?php get_footer() ?>