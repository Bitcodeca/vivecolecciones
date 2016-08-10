<?php
/*
	==========================================
	 Include scripts
	==========================================
*/
function vive_script_enqueue() {
	//css
     wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(), '3.3.6', 'all');
     wp_enqueue_style('datepicker', 'https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', array(), '1.11.4', 'all');
     wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.css', array(), '1.0.0', 'all');
     wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css', array(), '2.0.0', 'all');
	
    //js
    wp_enqueue_script('jquery', 'http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js', array(), '2.1.3', true);
    wp_enqueue_script('jquerydatepicker', 'http://code.jquery.com/ui/1.11.4/jquery-ui.js', array(), '1.11.4', true);
    wp_enqueue_script('bootstrapjs', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array(), '3.3.6', true);
    wp_enqueue_script('mixitupjs', 'https://cdnjs.cloudflare.com/ajax/libs/mixitup/2.1.11/jquery.mixitup.min.js', array(), '2.1.11', true);
    wp_enqueue_script('mixituppaginationjs',  'http://tseoc.co.uk/chris/jquery.mixitup-pagination.min.js', array(), '1.0.0', true);
}
add_action( 'wp_enqueue_scripts', 'vive_script_enqueue');

function menunavbar() {
	add_theme_support('menus');
    register_nav_menu('admin', 'Administrador');
    register_nav_menu('user', 'Usuario');
    register_nav_menu('contributor', 'Analista');
	}
add_action('init', 'menunavbar');

////////////////////////
// TAXONOMIA GERENTE //
//////////////////////
add_action( 'init', 'taxonomiagerente', 0 );
function taxonomiagerente() {
  $labels = array(
    'name' => _x( 'Gerente', 'taxonomy general name' ),
    'singular_name' => _x( 'Gerente', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Gerente' ),
    'all_items' => __( 'Todos los Gerentes' ),
    'edit_item' => __( 'Editar Gerente' ), 
    'update_item' => __( 'Actualizar Gerente' ),
    'add_new_item' => __( 'Añadir Gerente' ),
    'new_item_name' => __( 'Nuevo Gerente' ),
    'menu_name' => __( 'Gerente' ),
  );    
  register_taxonomy('Gerente',array('post'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'gerente' ),
  ));

}

////////////////////////
// TAXONOMIA CAMPAÑA //
//////////////////////
add_action( 'init', 'taxonomiacampana', 0 );
function taxonomiacampana() {
  $labels = array(
    'name' => _x( 'Campaña', 'taxonomy general name' ),
    'singular_name' => _x( 'Campaña', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Campaña' ),
    'all_items' => __( 'Todos los Campañas' ),
    'edit_item' => __( 'Editar Campaña' ), 
    'update_item' => __( 'Actualizar Campaña' ),
    'add_new_item' => __( 'Añadir Campaña' ),
    'new_item_name' => __( 'Nueva Campaña' ),
    'menu_name' => __( 'Campaña' ),
  );    
  register_taxonomy('campaña',array('admin'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'campaña' ),
  ));

}
/////////////////////////////////////////////////////////////////////
// AGREGAR NOMBRE DE USUARIOS A TAXONOMIA GERENTE AUTOMATICAMENTE //
///////////////////////////////////////////////////////////////////
function termsgerente() {
        $blogusers = get_users( 'role=subscriber' );
        foreach ( $blogusers as $user ) {
            $usuario= esc_html( $user->user_login );
            if( !term_exists( $usuario , 'Gerente' ) ) {
               wp_insert_term(
                   $usuario,
                   'Gerente',
                   array(
                     'description' => 'Gerente',
                     'slug'        => $usuario
                   )
               );
           }
        }
 } add_action( 'init', 'termsgerente', 0 );

function termscampana() {
        $blogusers = get_users( 'role=subscriber' );
        foreach ( $blogusers as $user ) {
            $usuario= esc_html( $user->user_login );
            if( !term_exists( $usuario , 'campaña' ) ) {
               wp_insert_term(
                   $usuario,
                   'campaña',
                   array(
                     'description' => 'campaña',
                     'slug'        => $usuario
                   )
               );
           }
        }
 } add_action( 'init', 'termscampana', 0 );

//////////////////////
// TAXONOMIA COSTO //
////////////////////
add_action( 'init', 'costo_taxonomy', 0 );
function costo_taxonomy() {
  $labels = array(
    'name' => _x( 'Costo', 'taxonomy general name' ),
    'singular_name' => _x( 'Costo', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Costo' ),
    'popular_items' => __( 'Costos frecuentes' ),
    'all_items' => __( 'Todas los Costos' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar Costo' ), 
    'update_item' => __( 'Actualizar Costo' ),
    'add_new_item' => __( 'Agregar nuevo Costo' ),
    'new_item_name' => __( 'Cantidad de nuevo Costo' ),
    'separate_items_with_commas' => __( '' ),
    'add_or_remove_items' => __( 'Agregar o Quitar Costo' ),
    'choose_from_most_used' => __( 'Escoger de los cosotos utilizados' ),
    'menu_name' => __( 'Costo' ),
  ); 
  register_taxonomy('costo','post',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'costo' ),
  ));
}

/////////////////////////
// TAXONOMIA CANTIDAD //
///////////////////////
add_action( 'init', 'cantidad_taxonomy', 0 );
function cantidad_taxonomy() {
  $labels = array(
    'name' => _x( 'Cantidad', 'taxonomy general name' ),
    'singular_name' => _x( 'Cantidad', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Cantidad' ),
    'popular_items' => __( 'Candidades frecuentes' ),
    'all_items' => __( 'Todas las Cantidades' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar Cantidad' ), 
    'update_item' => __( 'Actualizar Cantidad' ),
    'add_new_item' => __( 'Agregar nueva Cantidad' ),
    'new_item_name' => __( 'Nueva Cantidad' ),
    'separate_items_with_commas' => __( '' ),
    'add_or_remove_items' => __( 'Agregar o Quitar Cantidad' ),
    'choose_from_most_used' => __( 'Escoger de las Cantidades utilizadas' ),
    'menu_name' => __( 'Cantidad' ),
  ); 
  register_taxonomy('cantidad','post',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'cantidad' ),
  ));
}

///////////////////////////////////
// TAXONOMIA GANANCIA VENDENDOR //
/////////////////////////////////
add_action( 'init', 'gananciavendedor_taxonomy', 0 );
function gananciavendedor_taxonomy() {
  $labels = array(
    'name' => _x( 'Ganancia Vendedor', 'taxonomy general name' ),
    'singular_name' => _x( 'Ganancia Vendedor', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Ganancia Vendedor' ),
    'popular_items' => __( 'Ganancia Vendedor frecuentes' ),
    'all_items' => __( 'Todas las Ganancia Vendedor' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar Ganancia Vendedor' ), 
    'update_item' => __( 'Actualizar Ganancia Vendedor' ),
    'add_new_item' => __( 'Agregar nueva Ganancia Vendedor' ),
    'new_item_name' => __( 'Nueva Ganancia Vendedor' ),
    'separate_items_with_commas' => __( '' ),
    'add_or_remove_items' => __( 'Agregar o Quitar Ganancia Vendedor' ),
    'choose_from_most_used' => __( 'Escoger de las Cantidades utilizadas' ),
    'menu_name' => __( 'Ganancia Vendedor' ),
  ); 
  register_taxonomy('gananciavendedor','admin', array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'gananciavendedor' ),
  ));
}

//////////////////////////////
// TAXONOMIA PREMIO BASICO //
////////////////////////////
add_action( 'init', 'premiobasico_taxonomy', 0 );
function premiobasico_taxonomy() {
  $labels = array(
    'name' => _x( 'Premio Básico', 'taxonomy general name' ),
    'singular_name' => _x( 'Premio Básico', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Premio Básico' ),
    'popular_items' => __( 'Premio Básico frecuentes' ),
    'all_items' => __( 'Todas los Premio Básico' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar Premio Básico' ), 
    'update_item' => __( 'Actualizar Premio Básico' ),
    'add_new_item' => __( 'Agregar nueva Premio Básico' ),
    'new_item_name' => __( 'Nuevo Premio Básico' ),
    'separate_items_with_commas' => __( '' ),
    'add_or_remove_items' => __( 'Agregar o Quitar Premio Básico' ),
    'choose_from_most_used' => __( 'Escoger de las Cantidades utilizadas' ),
    'menu_name' => __( 'Premio Básico' ),
  ); 
  register_taxonomy('premiobasico','admin', array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'premiobasico' ),
  ));
}

/////////////////////////////
// TAXONOMIA DISTRIBUCION //
///////////////////////////
add_action( 'init', 'distribucion_taxonomy', 0 );
function distribucion_taxonomy() {
  $labels = array(
    'name' => _x( 'Distribución', 'taxonomy general name' ),
    'singular_name' => _x( 'Distribución', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Distribución' ),
    'popular_items' => __( 'Distribución frecuentes' ),
    'all_items' => __( 'Todas las Distribuciones' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar Distribución' ), 
    'update_item' => __( 'Actualizar Distribución' ),
    'add_new_item' => __( 'Agregar nuevo Distribución' ),
    'new_item_name' => __( 'Nueva Distribución' ),
    'separate_items_with_commas' => __( '' ),
    'add_or_remove_items' => __( 'Agregar o Quitar Distribución' ),
    'choose_from_most_used' => __( 'Escoger de las Cantidades utilizadas' ),
    'menu_name' => __( 'Distribución' ),
  ); 
  register_taxonomy('distribucion','admin', array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'distribucion' ),
  ));
}

/////////////////////////
// TAXONOMIA GERENCIA //
///////////////////////
add_action( 'init', 'gerencia_taxonomy', 0 );
function gerencia_taxonomy() {
  $labels = array(
    'name' => _x( 'Gerencia', 'taxonomy general name' ),
    'singular_name' => _x( 'Gerencia', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Gerencia' ),
    'popular_items' => __( 'Gerencia frecuentes' ),
    'all_items' => __( 'Todas las Gerencias' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar Gerencia' ), 
    'update_item' => __( 'Actualizar Gerencia' ),
    'add_new_item' => __( 'Agregar nuevo Gerencia' ),
    'new_item_name' => __( 'Nueva Gerencia' ),
    'separate_items_with_commas' => __( '' ),
    'add_or_remove_items' => __( 'Agregar o Quitar Gerencia' ),
    'choose_from_most_used' => __( 'Escoger de las Cantidades utilizadas' ),
    'menu_name' => __( 'Gerencia' ),
  ); 
  register_taxonomy('gerencia','admin', array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'gerencia' ),
  ));
}

/////////////////////////
// TAXONOMIA INCENTIVO //
///////////////////////
add_action( 'init', 'incentivo_taxonomy', 0 );
function incentivo_taxonomy() {
  $labels = array(
    'name' => _x( 'Incentivo', 'taxonomy general name' ),
    'singular_name' => _x( 'Incentivo', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Incentivo' ),
    'popular_items' => __( 'Incentivo frecuentes' ),
    'all_items' => __( 'Todas los Incentivo' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar Incentivo' ), 
    'update_item' => __( 'Actualizar Incentivo' ),
    'add_new_item' => __( 'Agregar nuevo Incentivo' ),
    'new_item_name' => __( 'Nuevo Incentivo' ),
    'separate_items_with_commas' => __( '' ),
    'add_or_remove_items' => __( 'Agregar o Quitar Incentivo' ),
    'choose_from_most_used' => __( 'Escoger de las Cantidades utilizadas' ),
    'menu_name' => __( 'Incentivo' ),
  ); 
  register_taxonomy('incentivo','admin', array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'incentivo' ),
  ));
}

////////////////////////
// CUSTOM POST ADMIN //
//////////////////////
function postadmin(){
   $args = array(
   'labels'=> array( 'name'=>'admin',
       'singular_name'=> 'admin',
       'menu_name'=>'Admin',
       'name_admin_bar'=> 'admin',
       'all_items' =>'Ver todas las publicaciones',
       'add_new'=> 'Añadir nueva publicación' ),
   'description' =>"Este tipo de post es para el admin",
   'public' => true,
   'exclude_from_search'=>false,
   'publicly_queryable'=> true,
   'show_ui' => true,
   'show_in_menu'=> true,
   'show_in_admin_bar'=> true,
   'menu_position'=>6,
   'capability_type'=> 'page',
   'supports'=> array( 'title'),
  'taxonomies' => array('gananciavendedor', 'premiobasico', 'distribucion', 'gerencia', 'Gerente', 'incentivo', 'campaña'),
   'query_var'=>true,
  );
  register_post_type( "admin", $args );
 }
 add_action("init","postadmin");

////////////////////////////////////////////
// BUSQUEDA DE TAXONOMIA GERENTE EN POST //
//////////////////////////////////////////
function buscargerente() {
    global $typenow;
    $post_type = 'post';
    $taxonomy = 'Gerente';
    if ($typenow == $post_type) {
        $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
        $info_taxonomy = get_taxonomy($taxonomy);
        wp_dropdown_categories(array(
            'show_option_all' => __("Mostrar todos los {$info_taxonomy->label}"),
            'taxonomy' => $taxonomy,
            'name' => $taxonomy,
            'orderby' => 'name',
            'selected' => $selected,
            'show_count' => true,
            'hide_empty' => true,
        ));
    };
}
add_action('restrict_manage_posts', 'buscargerente');
function buscargerentetabla($query) {
    global $pagenow;
    $post_type = 'post';
    $taxonomy = 'Gerente';
    $q_vars = &$query->query_vars;
    if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
        $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
        $q_vars[$taxonomy] = $term->slug;
    }
}
add_filter('parse_query', 'buscargerentetabla');




 class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu
{
    function start_lvl( &$output, $depth = 0, $args = array() )
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu dropdown-menu\">\n";
    }

    function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        $element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        if($item->current || $item->current_item_ancestor || $item->current_item_parent){
            $class_names .= ' active';
        }
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= $indent . '<li' . $id . $class_names .'>';
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        $atts['class']  = ($item->hasChildren)         ? 'dropdown-toggle' : '';
        $atts['data-toggle']  = ($item->hasChildren)   ? 'dropdown'        : '';
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        if( $item->hasChildren) {
            $item_output .= ' <b class="caret"></b>';
        }
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
update_option('image_default_link_type','none');
