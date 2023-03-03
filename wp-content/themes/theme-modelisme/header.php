<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
          crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href=" <?php echo get_template_directory_uri() . "/style.css"?>">

    <title>Thème custom</title>
</head>
<body>


<header class="header-content d-flex justify-content-between">
    <a class="" href="<?php echo get_bloginfo('wpurl') ?>">
    <img src=" <?php echo get_template_directory_uri() . "/img/logo.png"?>" alt="">
    </a>
    
    
    <a class="" href="<?php echo get_bloginfo('wpurl') ?>">
    <h2><?php echo get_bloginfo('name')  ?></h2>
    </a>

    <em class="">
        <?php echo get_bloginfo('description')  ?>
    </em>

<!--    on appelle notre menu principal-->

    <?php echo wp_nav_menu([
            "theme_location" => "menu-sup", // récupération du menu (avec le slug (identifiant))
            "container" => "nav", // type de balise qui va le contenir
            "container_class" => "navbar navbar-expand-lg justify-content-end menu-top ", // quelles classes pour le container du menu ?
            "menu_class" => "navbar-nav mr-auto", // quelles classes pour le menu ?
            "menu-id" => "", // ajouter un id ?
            "walker" => new Main_Menu_Dropdown_Walker() // récupération de la classe
    ]) ?>

</header>