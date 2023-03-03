<?php
/*
 * Plugin Name: Plugin projet pro club
 * Description: Mon super plugin
 * Author: PP Marion
 * Version: 0.0.1
 */


// on importe le fichier PP_database_service
require_once plugin_dir_path(__FILE__) . "/service/pp_database_service.php";
// on importe notre classe PP_List
require_once plugin_dir_path(__FILE__) . "/PP_List_Club.php";

//création de la class du plugin
class PP_Club
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
        add_action('admin_menu', array($this, 'add_menu_club'));

    }

    //creation du menu client dans le bo
    public function add_menu_club()
    {
        add_menu_page(
            'Les clubs PP',
            'Clubs PP',
            'manage_options',
            'club-pp',
            //l'élément qu'on veut afficher dans la page (rendu)
            array($this, "mes_clubs"),
            'dashicons-groups',
            40,

        );

        //ajouter un sous menu
        add_submenu_page(
            'club-pp',
            'Ajouter un club',
            'Ajouter',
            'manage_options',
            'add-club',
            array($this, "mes_clubs")
        );


    }

    //on créee la méthode mes_clients()
    public function mes_clubs()
    {
        // on doit instancier la classe PP_database_service
        $db = new PP_database_service();
        // on récupère le titre de la page
        echo "<h2> " . get_admin_page_title() . " </h2>";

        if ($_REQUEST['page'] == 'club-pp' || $_POST['send'] == 'ok' || $_POST['action'] == 'delete-club') {
            // on va mettre une seconde condition if
            // si on a bien les données du formulaire
            // on execute la requete d'insertion
            if (isset($_POST['send']) && $_POST['send'] == 'ok') {
                $db->save_club();
            }
            if (isset($_POST['action']) && $_POST['action'] == 'delete-club') {

                $db->delete_club($_POST['delete-club']);
            }

            if (isset($_POST['action']) && $_POST['action'] == 'update-club') {

                $db->update_club($_POST['update-club']);
            }


            $table = new PP_List_Club(); // on instancie la class
            $table->prepare_items(); // on appelle la méthode préapre items


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
                    <label for="">Adresse</label>
                    <input type="text" id="adresse" name="adresse" class="widefat" required>
                </div>


                <div>
                    <label for="">email</label>
                    <input type="text" id="email" name="email" class="widefat" required>
                </div>

                <div>
                    <label for="">Téléphone</label>
                    <input type="text" id="telephone" name="telephone" class="widefat" required>
                </div>


                <div>
                    <label for="">Domaine</label>
                    <input type="radio" name="domaine" class="widefat" value="auto" checked>Auto
                    <input type="radio" name="domaine" class="widefat" value="drone">Drone
                </div>


                <div>
                    <label for="">Championnat ?</label>
                    <input type="radio" name="is_championnat" class="widefat" value="1" checked>oui
                    <input type="radio" name="is_championnat" class="widefat" value="0">non
                </div>

                <div>
                    <button type="submit"> Envoyer</button>
                </div>


            </form>


            <?php
        }


    }



}

new PP_Club(); // on instancie la classe