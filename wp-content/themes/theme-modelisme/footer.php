<footer>

    <div class="d-flex flex-row justify-content-between p-3 content-footer">
        <div class="para-f">
            <h4> À  propos de nous...</h4>
            <p class="p-footer">Nous sommes une association de modélisme. Nous pilotons des bateaux, des avions, des hélicos,
                on trouve ça génial. On peut faire ça toute la journée.
                Vous pouvez venir nous voir aux horaires d'ouverture de la piste
                si vous voulez essayer quelques engins que l'association met à votre disposition,
                ou simplement nous demander conseil pour les réparations
                quand vous faites crasher vos apareils.</p>
        </div>


<div class="separator"></div>


    <div class="para-f">
        <h4> Liens utiles </h4>
    <?php echo wp_nav_menu([
        "theme_location" => "menu-footer", // récupération du menu (avec le slug (identifiant))
        "container" => "nav", // type de balise qui va le contenir
        "container_class" => "navbar justify-content-end me-5 ", // quelles classes pour le container du menu ?
        "menu_class" => "navbar-nav", // quelles classes pour le menu ?
        "menu-id" => "", // ajouter un id ?
        "walker" => new Main_Menu_Walker() // récupération de la classe
    ]) ?>
    </div>


        <div class="separator"></div>


        <div class="para-f social">
            <h4> Nos réseaux</h4>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""> <i class="bi bi-whatsapp"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""> <i class="bi bi-github"></i></a>
            <p>Contactez-nous !</p>

        </div>

    </div>


    <p class="bottom-footer">
        &copy; Modélisme 2023, tous les droits sont reservés, on a pris aucun visuel
        ni aucun texte sur d'autres sites.
    </p>


</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ"
        crossorigin="anonymous"></script>

</body>
</html>