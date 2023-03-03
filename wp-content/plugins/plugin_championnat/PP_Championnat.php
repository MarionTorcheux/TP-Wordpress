<?php
/*
 * Plugin Name: Plugin projet pro championnat
 * Description: Mon super plugin
 * Author: PP Marion
 * Version: 0.0.1
 */


// on importe le fichier PP_database_service
require_once plugin_dir_path(__FILE__) . "/service/pp_database_service_championnat.php";
// on importe notre classe PP_List
require_once plugin_dir_path(__FILE__) . "/PP_List_Championnat.php";

//création de la class du plugin
class PP_Championnat
{

    public function __construct()
    {
        // à l'activation du plugin : création des tables dans la bdd
        register_activation_hook(__FILE__, array('pp_database_service', 'create_db'));
        // à la desactivation du plugin, on vide les tables
        register_deactivation_hook(__FILE__, array('pp_database_service', 'empty_db'));
        // à la supression du plugin, on supprime la table
        // register_uninstall_hook(__FILE__,array('pp_database_service', 'delete_db'));


        // enregistrement du nouveau menu
        add_action('admin_menu', array($this, 'add_menu_championnat'));

    }
    //creation du menu adherent dans le bo
    public function add_menu_adherent()
    {
        add_menu_page(
            'Les championnats PP',
            'Championnats PP',
            'manage_options',
            'championnat-pp',
            //l'élément qu'on veut afficher dans la page (rendu)
            array($this, "mes_championnats"),
            'dashicons-buddicons-activity',
            40,

        );

        //ajouter un sous menu
        add_submenu_page(
            'championnat-pp',
            'Ajouter un championnat',
            'Ajouter',
            'manage_options',
            'add-championnat',
            array($this, "mes_championnat")
        );


    }

    //on créee la méthode mes_adherents()
    public function mes_championnats()
    {
        // on doit instancier la classe PP_database_service
        $db = new PP_database_service_championnat();
        // on récupère le titre de la page
        echo "<h2> " . get_admin_page_title() . " </h2>";

        if ($_REQUEST['page'] == 'championnat-pp' || $_POST['send'] == 'ok' || $_POST['action'] == 'delete-championnat') {
            // on va mettre une seconde condition if
            // si on a bien les données du formulaire
            // on execute la requete d'insertion
            if (isset($_POST['send']) && $_POST['send'] == 'ok') {
                $db->save_championnat();
            }
            if (isset($_POST['action']) && $_POST['action'] == 'delete-championnat') {

                $db->delete_championnat($_POST['delete-adherent']);
            }

            if (isset($_POST['action']) && $_POST['action'] == 'update-championnat') {

                $db->update_championnat($_POST['update-championnat']);
            }


            $table = new PP_List_championnat(); // on instancie la class
            $table->prepare_items(); // on appelle la méthode prépare items


            echo "<form action='' method='POST'>";
            echo $table->display(); // on affiche la table grace à display()
            echo "</form>";


        } else {
            // on affiche le formulaire
            ?>
            <form action="" method="post">
                <!--               on place un input hidden -->
                <!--               permet d'envoyer ok lorsqu'on poste le formulaire-->
                <!--               cette valeur ok servira de flag pour faire du traitement dessus-->
                <input type="hidden" name="send" value="ok">
                <div>
                    <label for="">Nom</label>
                    <input type="text" id="nom" name="nom" class="widefat" required>
                </div>

                <div>
                <label for="">Catégorie</label>
                <input type="text" id="categorie" name="categorie" class="widefat" required>
                </div>


                <div>
                    <button type="submit">Envoyer</button>
                </div>


            </form>


            <?php
        }


    }



}

new PP_championnat(); // on instancie la classe