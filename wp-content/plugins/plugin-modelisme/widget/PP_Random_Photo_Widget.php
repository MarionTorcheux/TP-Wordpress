<?php

class PP_Random_Photo_Widget extends WP_Widget {
	//on va appeler le constructor
	public function __construct() {
		$widget_ops = array(
			//ajout d'une classe
			'className'=>'PP_random_photo',
			//description avec la fonction __()
			'description'=> __( 'Widget pour avoir des photos aléatoires' ),
			//pour éviter de rafraichir le navigateur
			'customize_selective_refresh' => true
		);
		//on va devoir surcharger le construct de la class WP_widget
		parent::__construct( 'photos', __( 'Photos Widget PP' ), $widget_ops );
	}

	//créer le formulaire pour le back office
	public function form( $instance ) {
		//créer les valeurs par defaut
		//wp_parse_args permet de fusionner les valeurs dans un tableau
		$instance = wp_parse_args( (array) $instance, array(
			"query" => "",//propriété pour le mot clé
			"nbr"   => "",//propriété pour le nbr de photos à générer
			"cle"   => "",//propriété pour la clé secrète de l'api
		) );
		?>
<!--        //creation du formulaire-->
        <p>
            <label for="<?= $this->get_field_id( 'query' ) ?>">Mot de recherche</label>
            <input
                    type="text"
                    id="<?= $this->get_field_id( 'query' ) ?>"
                    name="<?= $this->get_field_name( 'query' ) ?>"
                    value="<?= esc_attr( $instance['query'] ) ?>"
            >
        </p>
        <p>
            <label for="<?= $this->get_field_id( 'nbr' ) ?>">Nombres de photos</label>
            <input
                    type="text"
                    id="<?= $this->get_field_id( 'nbr' ) ?>"
                    name="<?= $this->get_field_name( 'nbr' ) ?>"
                    value="<?= esc_attr( $instance['nbr'] ) ?>"
            >
        </p>
        <p>
            <label for="<?= $this->get_field_id( 'cle' ) ?>">Clé Unsplash</label>
            <input
                    type="text"
                    id="<?= $this->get_field_id( 'cle' ) ?>"
                    name="<?= $this->get_field_name( 'cle' ) ?>"
                    value="<?= esc_attr( $instance['cle'] ) ?>"
            >
        </p>
		<?php
	}
	//création de la fonction update
	//pour modifier les champs du formulaire
	//et générer d'autres images
	public function update( $new_instance, $old_instance ): array {
		$instance = $old_instance;
		//sanitize_text_field permet de formater le texte
		$instance['query'] = sanitize_text_field( ($new_instance['query']) );
		$instance['nbr']   = sanitize_text_field( ($new_instance['nbr']) );
		$instance['cle']   = sanitize_text_field( ($new_instance['cle']) );

		return $instance;
	}

	//construction du widget
	public function widget( $args, $instance ) {
		$title = "Photos";
		//nombre d'image minimum
		$nbr = ( $instance['nbr'] ) > 0 ? $instance['nbr'] : 1;
		//construire l'url pour l'appel d'API
		$url = "https://api.unsplash.com/search/photos?query=" . $instance['query'] . "&per_page=" . $nbr;
		//configuration du "headers" pour autoriser la consommation de l'API
		$argCle = [
			'headers' => [
				'Authorization' => 'Client-ID ' . $instance['cle']
			]
		];

		//appel à l'api grace à wp_remote_get (en GET)
		$request = wp_remote_get( $url, $argCle );
		//gestion d'erreur
		if ( is_wp_error( $request ) ) {
			return false;
		}

		//gestion du retour d'appel à l'API
		$body = wp_remote_retrieve_body( $request );
		$data = json_decode( $body, true );
		//construction du rendu HTML des images reçues
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];
		echo "<div class='photo'>";
		if ( ! empty( $data ) ) {
			for ( $i = 0; $i < $nbr; $i ++ ) {
				echo "<p>" . $data['results'][ $i ]['id'] . "</p>";
				echo "<img src='" . $data['results'][ $i ]['urls']['thumb'] . "'/>";
			}
		}
		echo "</div>";
		echo $args['after_widget'];

		return '';
	}


}