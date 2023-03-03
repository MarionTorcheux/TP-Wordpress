<?php
/*
 * Plugin Name: Plugin projet pro adherent
 * Description: Mon super plugin
 * Author: PP Marion
 * Version: 0.0.1
 */


// on importe le fichier PP_database_service
require_once plugin_dir_path(__FILE__) . "/service/pp_database_service.php";
// on importe notre classe PP_List
require_once plugin_dir_path(__FILE__) . "/PP_List_Adherent.php";

//création de la class du plugin
class PP_Adherent
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
        add_action('admin_menu', array($this, 'add_menu_adherent'));

    }
    //creation du menu adherent dans le bo
    public function add_menu_adherent()
    {
        add_menu_page(
            'Les adhérents PP',
            'Adhérents PP',
            'manage_options',
            'adherent-pp',
            //l'élément qu'on veut afficher dans la page (rendu)
            array($this, "mes_adherents"),
            'dashicons-admin-users',
            40,

        );

        //ajouter un sous menu
        add_submenu_page(
            'adherent-pp',
            'Ajouter un adhérent',
            'Ajouter',
            'manage_options',
            'add-adherent',
            array($this, "mes_adherents")
        );


    }

    //on créee la méthode mes_adherents()
    public function mes_adherents()
    {
        // on doit instancier la classe PP_database_service
        $db = new PP_database_service_adherent();
        // on récupère le titre de la page
        echo "<h2> " . get_admin_page_title() . " </h2>";

        if ($_REQUEST['page'] == 'adherent-pp' || $_POST['send'] == 'ok' || $_POST['action'] == 'delete-adherent') {
            // on va mettre une seconde condition if
            // si on a bien les données du formulaire
            // on execute la requete d'insertion
            if (isset($_POST['send']) && $_POST['send'] == 'ok') {
                $db->save_adherent();
            }
            if (isset($_POST['action']) && $_POST['action'] == 'delete-adherent') {

                $db->delete_adherent($_POST['delete-adherent']);
            }

            if (isset($_POST['action']) && $_POST['action'] == 'update-adherent') {

                $db->update_adherent($_POST['update-adherent']);
            }


            $table = new PP_List_Adherent(); // on instancie la class
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
                <label for="">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="widefat" required>
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
                    <label for="">Adresse</label>
                    <input type="text" id="adresse" name="adresse" class="widefat" required>
                </div>


                <div>
                    <label for="">N°licence</label>
                    <input type="text" id="numero_adherent" name="numero_adherent" class="widefat" required>
                </div>


                <div>
                    <label for="">Club</label>
                    <input type="text" id="club_id" name="club_id" class="widefat" required>
                </div>




                <div>
                    <button type="submit">Envoyer</button>
                </div>


            </form>


            <?php
        }


    }



}

new PP_Adherent(); // on instancie la classe