<?php

namespace widget;

use PP_database_service;
use WP_Widget;


class Classement extends WP_Widget
{
    //on va appeler le constructor
    public function __construct()
    {
        $widget_ops = array(

            //ajout d'une classe
            'className' => 'Classement',
            //description avec la fonction __()
            'description' => __('Widget pour avoir le top 3'),
            //pour éviter de rafraichir le navigateur
            'customize_selective_refresh' => true
        );
        //on va devoir surcharger le construct de la class WP_widget
        parent::__construct('classement', __('Classement'), $widget_ops);
    }


    //construction du widget
    public function widget($args, $instance)
    {
        $title = "Classement";


        $db = new PP_database_service();
        $request = $db->topTrois();
        $tab = json_decode(json_encode($request), true);


        //construction du rendu HTML
        echo $args['before_widget'];
        echo "<div class='widget-title'>" . $args['before_title'] . $title . $args['after_title'] . "</div>";

        echo "<div class='classement'>";
        for ($i = 0; $i < count($tab); $i++) {

            echo "<div class='content-classement m-3 p-3'>";
            echo " <h4>" . $tab[$i]['libelle'] . "</h4>";
            echo "<p>" . $tab[$i]['prenom'] . " " . $tab[$i]['nomAdherent'];
            echo " est arrivé(e) en position " . $tab[$i]['position'];
            echo " sur la course " . $tab[$i]['nom'] . ".";
            echo "</p></div>";

        }

        echo "</div>";
        echo $args['after_widget'];

        return '';
    }

}