<?php
/*
	==========================================
	 Include scripts
	==========================================
*/
function prototipo_script_enqueue() {
	//css
     wp_enqueue_style('Bootstrap grid', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1.0.0', 'all');
     wp_enqueue_style('Materializecss', 'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css', array(), '0.97.8', 'all');
     wp_enqueue_style('material icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), '1.0.0', 'all');
     wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css', array(), '2.1.49', 'all');

    //js
    wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js', array(), '3.1.0', true);
    wp_enqueue_script('Materialize js', 'https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js', array(), '0.97.8', true);


    if( is_page('agregar-campana') || is_page('chat') || is_page('asignar-dependencia') || is_page('centro-de-control') || is_page('registrar-pago') || is_page('registrar-deposito-problema') || is_page('devoluciones') || is_page('denuncias') || is_page('premios') || is_page('agregar-nueva-coleccion') || is_page('agregar-nuevo-premio') || is_page('comparacion') || is_page('duplicados') || is_page('analista') || is_page('prueba') ){
      wp_enqueue_script('angular', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js', array(), '3.1.0', true);
      wp_enqueue_script('appjs', get_template_directory_uri() . '/app.js', array(), '3.1.0', true);
    }
    if ( is_page('escritorio') ){
      wp_enqueue_style('fullcalendar css', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.min.css', array(), '1.0.0', 'all');
      wp_enqueue_script('moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js', array(), '1.0.0', true);
      wp_enqueue_script('fullcalendar js', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.min.js', array(), '1.0.0', true);
    }
    if ( is_page('buscar-deposito') || is_page('buscar-gerente') || is_page('devoluciones') || is_page('registrar-pago') || is_page('registrar-deposito-problema') || is_page('cambios') || is_page('averias') ){
      wp_enqueue_script('mixitupjs', 'https://cdnjs.cloudflare.com/ajax/libs/mixitup/2.1.11/jquery.mixitup.min.js', array(), '2.1.11', true);
      wp_enqueue_script('mixituppaginationjs',  'http://tseoc.co.uk/chris/jquery.mixitup-pagination.min.js', array(), '1.0.0', true);
    }
    if ( is_page('dependencias') || is_page('escritorio') || is_page('estructura') || is_page('buscar-factura') || is_page('facturacion') || is_page('averias') || is_page('cambios') || is_page('prueba') ){
      wp_enqueue_script('gcharts', 'https://www.gstatic.com/charts/loader.js', array(), '2.1.11', true);
    }
}
add_action( 'wp_enqueue_scripts', 'prototipo_script_enqueue');

function menunavbar() {
	add_theme_support('menus');
  register_nav_menu('admin', 'admin');
  register_nav_menu('gerente', 'gerente');
  register_nav_menu('analista', 'Analista');
  register_taxonomy('post_tag', array());
}
add_action('init', 'menunavbar');

// Add a custom user role
if( !get_role('Gerente') ){
  $result1 = add_role( 'Gerente', __('Gerente' ),
    array(
    'read' => true, // true allows this capability
    'edit_posts' => false, // Allows user to edit their own posts
    'edit_pages' => false, // Allows user to edit pages
    'edit_others_posts' => false, // Allows user to edit others posts not just their own
    'create_posts' => true, // Allows user to create new posts
    'manage_categories' => false, // Allows user to manage post categories
    'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
    'edit_themes' => false, // false denies this capability. User can’t edit your theme
    'install_plugins' => false, // User cant add new plugins
    'update_plugin' => false, // User can’t update any plugins
    'update_core' => false, // user cant perform core updates
    'upload_files' => true,
    'manage_options' => true,
    )
  );
}
// Add a custom user role
if( !get_role('Analista') ){
  $result1 = add_role( 'Analista', __('Analista' ),
    array(
    'read' => true, // true allows this capability
    'edit_posts' => false, // Allows user to edit their own posts
    'edit_pages' => false, // Allows user to edit pages
    'edit_others_posts' => false, // Allows user to edit others posts not just their own
    'create_posts' => true, // Allows user to create new posts
    'manage_categories' => false, // Allows user to manage post categories
    'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
    'edit_themes' => false, // false denies this capability. User can’t edit your theme
    'install_plugins' => false, // User cant add new plugins
    'update_plugin' => false, // User can’t update any plugins
    'update_core' => false, // user cant perform core updates
    'upload_files' => true,
    'manage_options' => true,
    )
  );
} 

//check if role exist before removing it
if( get_role('subscriber') ){
      remove_role( 'subscriber' );
}
//check if role exist before removing it
if( get_role('contributor') ){
      remove_role( 'contributor' );
}
//check if role exist before removing it
if( get_role('author') ){
      remove_role( 'author' );
}
//check if role exist before removing it
if( get_role('editor') ){
      remove_role( 'editor' );
}

//////////////////////////////////////////////////////////////
///////////////// INFO DEL USUARIO LOGGED ////////////////////
//////////////////////////////////////////////////////////////
function user_logged(){

  $user_logged=array();
  $current_user = wp_get_current_user();

  $user_logged["login"] = $current_user->user_login;
  $user_logged["nombre"] = $current_user->user_firstname;
  $user_logged["apellido"] = $current_user->user_lastname;
  $user_logged["email"] = $current_user->user_email;
  $user_logged["id"] = $current_user->id;
  $user_logged["rol"] = implode(', ', $current_user->roles);
  $user_logged["departamento"] = um_user('role');
  $user_logged["avatarxs"] = get_avatar( $current_user->id, 32 );
  $user_logged["avatarmd"] = get_avatar( $current_user->id, 64 );

  return $user_logged;
}



//////////////////////////////////////////////////////////////
///////////////// INFO DEL USUARIO LOGGED ////////////////////
//////////////////////////////////////////////////////////////
function user_by_login($login){

  $user_by_login=array();
  $user = get_user_by( 'login', $login );

  $user_by_login['nombre']=$user->first_name;
  $user_by_login['apellido']=$user->last_name;
  $user_by_login['id']=$user->id;
  preg_match('/src="(.*?)"/i', get_avatar( $user->id, 32 ), $fotoxs );
  $user_by_login['avatarxs']=$fotoxs[1];

  return $user_by_login;
}

function formato($valor){
   $numero=preg_replace("/[^0-9,.]/", "", $valor);
   $resultado=number_format($numero, 2, ',', '.');
   return $resultado;
}

function decimales($valor){
   $numero=preg_replace("/[^0-9,.]/", "", $valor);
   $resultado=number_format($numero, 2, '.', '');
   return $resultado;
}

function bancos(){
  $bancos=array();
  array_push($bancos, 'provincial');
  array_push($bancos, 'banesco');
  array_push($bancos, 'activo');
  array_push($bancos, 'bicentenario');
  array_push($bancos, 'venezuela');
  array_push($bancos, 'banplus');
  array_push($bancos, 'mercantil');
  array_push($bancos, 'bancaribe');
  array_push($bancos, 'bnc');
  array_push($bancos, 'venezolano');
  array_push($bancos, 'tesoro');
  return $bancos;
}

function status(){
  $status=array();
  array_push($status, 'aprobado');
  array_push($status, 'negado');
  array_push($status, 'pendiente');
  return $status;
}
function estado(){
  $estado=array();
  array_push($estado, 'Amazonas');
  array_push($estado, 'Anzoátegui');
  array_push($estado, 'Apure');
  array_push($estado, 'Aragua');
  array_push($estado, 'Barinas');
  array_push($estado, 'Bolivar');
  array_push($estado, 'Carabobo');
  array_push($estado, 'Cojedes');
  array_push($estado, 'Distrito Capital');
  array_push($estado, 'Delta Amacuro');
  array_push($estado, 'Falcón');
  array_push($estado, 'Guárico');
  array_push($estado, 'Lara');
  array_push($estado, 'Mérida');
  array_push($estado, 'Miranda');
  array_push($estado, 'Monagas');
  array_push($estado, 'Nueva Esparta');
  array_push($estado, 'Portuguesa');
  array_push($estado, 'Sucre');
  array_push($estado, 'Táchira');
  array_push($estado, 'Trujillo');
  array_push($estado, 'Vargas');
  array_push($estado, 'Yaracuy');
  array_push($estado, 'Zulia');
  return $estado;
}
function premiosTipo(){
  $premio=array();
  array_push($premio, 'Regalo Basico');
  array_push($premio, 'Regalo con Aporte');
  array_push($premio, 'Premio Efectivo');
  return $premio;
}

function usuarioPorRol($rol){

  $emailporrol=array();

  $args = array('role' => $rol);
  $usuarios=get_users( $args );

  foreach ($usuarios as $usuario) {
    $info['login']=$usuario->user_login;
    $info['nombre']=$usuario->user_firstname;
    $info['apellido']=$usuario->user_lastname;
    $info['email']=$usuario->user_email;
    preg_match('/src="(.*?)"/i', get_avatar( $usuario->id, 32 ), $fotoxs );
    $info['avatarxs']=$fotoxs[1];

    array_push($emailporrol, $info);
  }
  return $emailporrol;
}




if( ! class_exists( 'Materialize_Walker_Desktop_Nav_Menu' ) ) :

    class Materialize_Walker_Desktop_Nav_Menu extends Walker_Nav_Menu {

        private $curItem;

        /**
         * Starts the list before the elements are added.
         *
         * Adds classes to the unordered list sub-menus.
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   An array of arguments. @see wp_nav_menu()
         */
        function start_lvl( &$output, $depth = 0, $args = array() ) {

            // Depth-dependent classes.
            $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
            $display_depth = ( $depth + 1); // because it counts the first submenu as 0
            $classes = array(
                'sub-menu',
                ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
                ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
                'menu-depth-' . $display_depth
            );
            $class_names = implode( ' ', $classes );

            // Build HTML for output.
            $output .= "\n" . $indent . '<ul id="' . $this->curItem->post_name . '" class="' . $class_names . ' dropdown-content">' . "\n";
        }

        /**
         * Start the element output.
         *
         * Adds main/sub-classes to the list items and links.
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item   Menu item data object.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   An array of arguments. @see wp_nav_menu()
         * @param int    $id     Current item ID.
         */
        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            global $wp_query;
            $this->curItem = $item;
            $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

            // Depth-dependent classes.
            $depth_classes = array(
                ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
                ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
                ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
                'menu-item-depth-' . $depth
            );

            $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

            // Passed classes.
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

            // Build HTML.
            $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
            if( in_array( 'menu-item-has-children', $item->classes ) ) {$dropdown='dropdown-button ';}else{$dropdown='';}
            // Link attributes.
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $attributes .= ' class="menu-link ' .$dropdown. ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

            if( in_array( 'menu-item-has-children', $item->classes ) )
                $attributes .= ' data-activates="' . $item->post_name . '"';

            // Build HTML output and pass through the proper filter.
            $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
                $args->before,
                $attributes,
                $args->link_before,
                apply_filters( 'the_title', $item->title, $item->ID ),
                $args->link_after,
                $args->after
            );
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }

endif;

?>
