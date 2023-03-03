<?php



//création de la fonction register_menu


function register_menu()
{

    //fonction native de wordpress pour déclarer un menu
    register_nav_menus(
        ['menu-sup' => __('Menu supérieur'), // la fonction __() permet la traduction dans le backoffice
            'menu-footer' => __('Menu pied de page')
        ]
    );
}
// on utilise la méthode add_action pour injecter notre fonction
// 1er paramètre : le hook 'init', le 2ème la fonction
add_action('init','register_menu');


add_theme_support( 'custom-header' );

// on va créer le rendu du menu
class Main_Menu_Walker extends Walker_Nav_Menu
{
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
       //$output servira pour le rendu "html" du menu
        // $data_object servira à récupérer les infos du menu (grace au backoffice)
        // on récupère les datas du menu
        $title = $data_object->title; // récupère le titre
        $permalink = $data_object->url; // récupère le lien de redirection
        // on crée le template de rendu
        $output .= "<div class='nav-item'>";
        $output .= "<a href='".$permalink."'>";
        $output .= $title;
        $output .= "</a>";

    }


    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $output .= "</div>";
    }
}

class Main_Menu_Dropdown_Walker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= '<ul class="dropdown-menu">';
    }

    function start_el( &$output, $data_object, $depth = 0, $args = array(), $id = 0 ) {

        $title = $data_object->title;
        $permalink = $data_object->url;

        if ( $permalink != '#' ) {
            if ( $depth > 0 ) {
                $output .= '';
            } else {

                $output .= "<li class='nav-item'>";
            }
        } else {
            $output .= "<li class='nav-item dropdown'>";
        }

        //Add SPAN if no Permalink
        if ( $permalink && $permalink != '#' ) {
            if ( $depth > 0 ) {
                $output .= '<a href="' . $permalink . '" class="dropdown-item ">';
            } else {
                $output .= '<a href="' . $permalink . '" class="nav-link py-1 px-3 m-1 menu-style">';
            }
        } else {
            $output .= '<a href="' . $permalink .
                '" class="nav-link dropdown-toggle py-1 px-3 m-1 menu-style" data-bs-toggle="dropdown">';
        }

        $output .= $title;
        $output .= '</a>';
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = array() ) {
        if ( $depth > 0 ) {
            $output .= '';
        }
    }
}


function register_custom_widget_area(): void
{
    register_sidebar(
        array(
            'id' => 'new-widget-area',
            'name' => esc_html__( 'Zone widget ', 'theme-domain' ),
            'description' => esc_html__( 'Une zone pour contenir des widgets dans la sidebar',
                'theme-domain' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
            'after_title' => '</h3></div>'
        )
    );
}
add_action( 'widgets_init', 'register_custom_widget_area' );



