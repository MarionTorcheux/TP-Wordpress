<?php

class PP_database_service
{
    public function __construct()
    {
    }

    //création de la fonction pour creer des tables dans la bdd
    public static function create_db()
    {
        global $wpdb;
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}pp_club (ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT, nom VARCHAR(100), adresse VARCHAR(100), email VARCHAR(200), telephone VARCHAR(200), domaine VARCHAR(200), is_championnat BOOLEAN );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}pp_adherent (ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT, nom VARCHAR(100), prenom VARCHAR(100), email VARCHAR(200), telephone VARCHAR(200), adresse VARCHAR(200), numero_adherent VARCHAR(200), club_ID INT, FOREIGN KEY (club_ID) REFERENCES {$wpdb->prefix}pp_club (ID));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}pp_categorie_championnat(ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT, libelle VARCHAR(100));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}pp_championnat(ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT, nom VARCHAR(100), categorie_championnat_ID INT, FOREIGN KEY (categorie_championnat_ID) REFERENCES {$wpdb->prefix}pp_categorie_championnat(ID));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}pp_championnat_adherent(ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT, position INT, adherent_ID INT, championnat_ID INT, FOREIGN KEY (adherent_ID) REFERENCES {$wpdb->prefix}pp_adherent (ID), FOREIGN KEY (championnat_ID) REFERENCES {$wpdb->prefix}pp_championnat(ID));");

        $count_club = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}pp_club; ");
        $count_adherent = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}pp_adherent; ");
        $count_categorie = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}pp_categorie_championnat; ");
        $count_championnat = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}pp_championnat; ");
        $count_championnat_adherent = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}pp_championnat_adherent; ");
        if ($count_club == 0)
        {
            $wpdb->query("INSERT INTO {$wpdb->prefix}pp_club (nom, adresse, email, telephone, domaine, is_championnat) VALUES ('LesFripouillesVolantes', '17 rue des fripouilles', 'f@gmail.com', '0468957845', 'voiture',0),    ('AiméeLaVoiture', '16 rue des bagnoles', 'bagnole@gmail.com', '0645987453','drone',1),    ('beauBateau', '56 rue sur l\'eau', 'eau@gmail.com', '0698778954','voiture',1),    ('Farfelus', '70 rue des lacs', 'vavite@gmail.com', '0696987854','drone',1);");

        }

        if ($count_adherent == 0)
        {
            $wpdb->query(" INSERT INTO {$wpdb->prefix}pp_adherent (nom, prenom, email, telephone, adresse, numero_adherent, club_ID) VALUES ('Fripouille', 'Cyrielle', 'cyrielle@gmail.com', '0468957845', '47 avenue des fripouilles','01213115861',2), ('LaGalette', 'Marion', 'bagnole@gmail.com', '0645987453','19 av jules','056546541',1),    ('laGalette', 'Jaime', 'eau@gmail.com', '0698778954','45 rue des hiboux','0546545614',3), ('deLaFontaine', 'Jean', 'vavite@gmail.com', '0696987854','89 avenue des vaches','02455565',1);");

        }

        if ($count_categorie == 0)
        {
            $wpdb->query("INSERT INTO {$wpdb->prefix}pp_categorie_championnat (libelle) VALUES ('Automobile'),('Drone 3 rotors'),('Drone 4 rotors');");

        }

        if ($count_championnat == 0)
        {
            $wpdb->query("INSERT INTO {$wpdb->prefix}pp_championnat (nom, categorie_championnat_ID) VALUES ('Les fous du volant',1),('Les pneus creuvés',1),('La route sans nid de poule',1),('L\'enjoliveur doré',1),('La tête dans le guidon',1),('Le drone de la drome',2),('Course aux drones',2),('Drop ton drone',2),('Mon drone c\'est le plus beau',3), ('L\'île aux drones',3), ('Le drone joyeux',3);");

        }

        if ($count_championnat_adherent == 0)
        {
            $wpdb->query("INSERT INTO {$wpdb->prefix}pp_championnat_adherent (adherent_ID, championnat_ID, position)VALUES (1,11,1), (2,1,3), (3,10,6), (4,10,1), (1,1,2);");

        }


    }



    //créer une fonction qui permet de vider la table de toutes ses données
    // ATTENTION : a ne pas faire en cas réél sauf demande client
    public function empty_db()
    {
        global $wpdb;
        $wpdb->query("TRUNCATE {$wpdb->prefix}pp_club;");
    }


    //on crée une méthode qui supprime la table
    public function delete_db()
    {
        global $wpdb;
        $wpdb->query("DROP TABLE {$wpdb->prefix}pp_club;");
    }


    //requete pour récuprérer la liste des clubs
    public function findAllClubs()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}pp_club;");
        return $result;
    }

    public function save_club()
    {
        global $wpdb;
        //on récupère les données envoyées par le formulaire
        $valeurs = [
            'nom' => $_POST['nom'],
            'adresse' => $_POST['adresse'],
            'email' => $_POST['email'],
            'telephone' => $_POST['telephone'],
            'domaine' => $_POST['domaine'],
            'is_championnat' => $_POST['is_championnat'],

        ];

        //on vérifie que le club n'existe pas dans la bdd
        $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}pp_club WHERE email = '{$valeurs['email']}'; ");
        if (is_null($row)) {
            // si le club n'existe pas on peut l'insérer
            $wpdb->insert("{$wpdb->prefix}pp_club", $valeurs);
        }
    }

    // requete pour supprimer un club
    public function delete_club($ids)
    {


        global $wpdb;
        // on check si IDs sont dans un tableau sinon on le met dedans
        // il veut que un tableau pour supprimer meme si y a qu'un id
        // pour avoir la possibilité de supprimer plusieurs clients à la fois
        if (!is_array($ids)) {
            $ids = (array)$ids;
        }
        // requete de suppression
        $wpdb->query("DELETE FROM {$wpdb->prefix}pp_club WHERE ID IN (" . implode(',', $ids) . ");");

    }

    public function update_club($ids)
    {
        global $wpdb;
        echo "koukoukouk";

        // $wpdb->query("UPDATE {$wpdb->prefix}pp_club SET nom = '', prenom = '', email='', telephone='', fidelite =''");
    }




    //requete pour récuprérer la liste des clubs
    public function findAllAdherents()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT {$wpdb->prefix}pp_adherent.*, {$wpdb->prefix}pp_club.nom AS club FROM {$wpdb->prefix}pp_adherent INNER JOIN {$wpdb->prefix}pp_club ON {$wpdb->prefix}pp_adherent.club_ID = {$wpdb->prefix}pp_club.ID;");
        return $result;
    }

    public function save_adherent()
    {
        global $wpdb;
        //on récupère les données envoyées par le formulaire
        $valeurs = [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'email' => $_POST['email'],
            'telephone' => $_POST['telephone'],
            'adresse' => $_POST['adresse'],
            'numero_adherent' => $_POST['numero_adherent'],
            'club_ID' => $_POST['club_id'],

        ];

        //on vérifie que le club n'existe pas dans la bdd
        $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}pp_adherent WHERE email = '{$valeurs['email']}'; ");
        if (is_null($row)) {
            // si l'adherent n'existe pas on peut l'insérer
            $wpdb->insert("{$wpdb->prefix}pp_adherent", $valeurs);
        }
    }

    // requete pour supprimer un club
    public function delete_adherent($ids)
    {


        global $wpdb;
        // on check si IDs sont dans un tableau sinon on le met dedans
        // il veut que un tableau pour supprimer meme si y a qu'un id
        // pour avoir la possibilité de supprimer plusieurs clients à la fois
        if (!is_array($ids)) {
            $ids = (array)$ids;
        }
        // requete de suppression
        $wpdb->query("DELETE FROM {$wpdb->prefix}pp_adherent WHERE ID IN (" . implode(',', $ids) . ");");

    }




    public function update_adherent($ids)
    {
        global $wpdb;
        echo "koukoukouk";

        // $wpdb->query("UPDATE {$wpdb->prefix}pp_club SET nom = '', prenom = '', email='', telephone='', fidelite =''");
    }


    //requete pour récuprérer la liste des clubs
    public function findAllChampionnats()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT {$wpdb->prefix}pp_championnat.*, {$wpdb->prefix}pp_categorie_championnat.libelle FROM {$wpdb->prefix}pp_championnat INNER JOIN {$wpdb->prefix}pp_categorie_championnat ON {$wpdb->prefix}pp_categorie_championnat.ID = {$wpdb->prefix}pp_championnat.categorie_championnat_ID;");
        return $result;
    }

    public function save_championnat()
    {
        global $wpdb;
        //on récupère les données envoyées par le formulaire
        $valeurs = [
            'nom' => $_POST['nom'],
            'categorie_championnat_ID' => $_POST['categorie'],

        ];

        var_dump($_POST['categorie']);

        //on vérifie que le championnat n'existe pas dans la bdd
        $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}pp_championnat WHERE nom = '{$valeurs['nom']}'; ");
        if (is_null($row)) {
            // si le championnat n'existe pas on peut l'insérer
            $wpdb->insert("{$wpdb->prefix}pp_championnat", $valeurs);
        }
    }

    // requete pour supprimer un club
    public function delete_championnat($ids)
    {


        global $wpdb;
        // on check si IDs sont dans un tableau sinon on le met dedans
        // il veut que un tableau pour supprimer meme si y a qu'un id
        // pour avoir la possibilité de supprimer plusieurs clients à la fois
        if (!is_array($ids)) {
            $ids = (array)$ids;
        }
        // requete de suppression
        $wpdb->query("DELETE FROM {$wpdb->prefix}pp_championnat WHERE ID IN (" . implode(',', $ids) . ");");

    }



    public function update_championnat($ids)
    {
        global $wpdb;
        echo "koukoukouk";

        // $wpdb->query("UPDATE {$wpdb->prefix}pp_club SET nom = '', prenom = '', email='', telephone='', fidelite =''");
    }

}