<?php
// certaines versions de wordpress n'arrivent pas à étendre la classe WP_List
// pour y remédier, on changera la classe manuellement


if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

// on importe notre class PP_database_service
require_once plugin_dir_path(__FILE__) . '/service/pp_database_service.php';

class PP_List_Club extends WP_List_Table
{
    private $dal;

    // on a surchargé le constructeur
    public function __construct($args = array())
    {
        parent::__construct([
            'singular' => __('Club'),
            'plural' => __('Clubs'),
        ]);

        $this->dal = new PP_database_service();
    }

    // on va préparer notre liste
    public function prepare_items()
    {
        // on va préparer toutes les variables dont on va avoir besoin
        $columns = $this->get_columns(); // on récupère les colonnes
        $hidden = $this->get_hidden_columns(); // on ajoute cette variable si on veut masquer des colonnes
        $sortable = $this->get_sortable_columns(); // permet de trier des colonnes

        // pagination
        // pour afficher un nbr de résultat par page
        $perPage = $this->get_items_per_page('club_per_page', 10);
        $currentPage = $this->get_pagenum(); // permet de savoir sur quelle page on est

        // on traite les données
        $data = $this->dal->findAllClubs(); // pour récupérer les infos de la bdd

        $totalPage = count($data); // pour savoir le nbr de lignes de $data

        // on traite le tri
        usort($data, array(&$this, 'usort_reorder')); // &this => pour faire référence à notre classe

        $paginationData = array_slice($data, (($currentPage - 1) * $perPage), $perPage);

        // on redéfinit les valeurs de la pagination
        $this->set_pagination_args([
            'total_items' => $totalPage,
            'per_page' => $perPage
        ]);

        // on injecte les différentes data aux colonnes
        $this->_column_headers = [$columns, $hidden, $sortable];

        //On alimente les champs de donneés
        $this->items = $paginationData;

    }

    // on va surcharger la fonction get_column
    public function get_columns(): array
    {
        $columns = [
            'cb' => "<input type ='checkbox'/>",
            'ID' => 'id',
            'nom' => 'Nom',
            'adresse' => 'Adresse',
            'email' => 'Email',
            'telephone' => 'Téléphone',
            'domaine' => 'Domaine',
            'is_championnat' => 'Championnat',
        ];

        return $columns;
    }


    // function supplémentaire si on veut cacher des colonnes
    public function get_hidden_columns(): array
    {
        return []; // on retourne un tableau vide quand on ne veut rien cacher
        // ex : return ['telephone' => 'Téléphone'];

    }


    // on s'occupe de la fonction qui va gérer le tri
    public function usort_reorder($a, $b)
    {
        //si on passe un paramètre de tri dans l'url, on le traite
        // sinon par défaut on trie par l'id
        $orderBy = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'id';
        // idem pour l'ordre de tri
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'desc';
        // on crée la mécanique
        $result = strcmp($a->$orderBy, $b->$orderBy); // on compare string a avec string b
        return ($order === 'asc') ? $result : -$result; // -$result inverse le tableau

    }

    // permet de remplir le nom des colonnes par défaut
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'ID' :
            case 'nom' :
            case 'adresse' :
            case 'email' :
            case 'telephone' :
            case 'domaine' :
                return $item->$column_name;
                break;
            case 'is_championnat' :
                return $item->$column_name == 0 ? "non" : "oui";
            default :
                return print_r($item, true);
        }
    }

    //permet d'affilier les colonnes que l'on souhaite trier
    public function get_sortable_columns()
    {
        $sortable = [
            'ID' => array('ID', true),
            'nom' => array('nom', true),
            'domaine' => array('domaine', true),
            'is_championnat' => array('is_championnat', true),
        ];
        return $sortable;

    }


    public function column_cb($item)
    {       // convertir l'élément en tableau

        $item = (array)$item;


        // retourner une checkbox pour chaque élément du tableau
        return sprintf(
            "<input type='checkbox' name='delete-club[]' value='%s' />", $item['ID']
        );
    }

    public function get_bulk_actions()
    {
        return array(
            'delete-club' => __('Delete'),
            'update-club' => __('Update')
        );
    }


}