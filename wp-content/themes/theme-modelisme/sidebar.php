<div class="col-sm-3 offset-sm-1 blog-sidebar border sidebar-content">
    <div class="sidebar-module">





        <?php
        if (is_active_sidebar('new-widget-area')) : ?>
            <div id="secondary-sidebar" class="new-widget-area">
                <?php dynamic_sidebar('new-widget-area'); ?>


            </div>

        <?php endif; ?>


    </div>
</div>