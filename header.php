<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="theme-color" content="#1A2E61">
        <meta name="msapplication-navbutton-color" content="#1A2E61">
        <meta name="apple-mobile-web-app-status-bar-style" content="#1A2E61">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">

		<title>INTRANET - Vive Colecciones</title>

        <meta name="robots" content="NOFOLLOW, NOINDEX">

        <link rel="icon" type="image/x-icon" href="<?php echo get_bloginfo('template_directory');?>/img/favicon.ico" />
        <link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_directory');?>/img/favicon.png" />
        <link rel="icon" type="image/gif" href="<?php echo get_bloginfo('template_directory');?>/img/favicon.gif" />

        <link rel="icon" sizes="192x192" href="<?php echo get_bloginfo('template_directory');?>/img/192favicon.png">
        <link rel="icon" sizes="128x128" href="<?php echo get_bloginfo('template_directory');?>/img/128favicon.png">

		<?php wp_head(); ?>
        <?php if ( is_user_logged_in() ) {
                $user_logged=user_logged();

                $buscarlogged=$user_logged['login'];
                $conn = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");

                $stmt_ORDER = $conn->prepare("SELECT sum(case when visto = 'N' then 1 else 0 end) as notifMSN FROM vive_msn WHERE fin='$buscarlogged'");
                $stmt_ORDER->execute();
                $stmt_ORDER->bind_result($notifMSN);
                $stmt_ORDER->store_result();
                while ($stmt_ORDER->fetch()) { $msn=$notifMSN; }
                $stmt_ORDER->close();

                if($user_logged['rol']=='administrator'){
                    $stmt_ORDER = $conn->prepare("SELECT id FROM vive_dev");
                    $stmt_ORDER->execute();
                    $stmt_ORDER->store_result();
                    $notifDev = $stmt_ORDER->num_rows;
                    $stmt_ORDER->close();

                    $stmt_ORDER = $conn->prepare("SELECT id FROM vive_cambio WHERE status='pendiente'");
                    $stmt_ORDER->execute();
                    $stmt_ORDER->store_result();
                    $notifCamb = $stmt_ORDER->num_rows;
                    $stmt_ORDER->close();

                    $stmt_ORDER = $conn->prepare("SELECT vive_pen.id FROM vive_dep JOIN vive_pen ON vive_pen.referencia = vive_dep.referencia AND vive_pen.fecha = vive_dep.fecha AND vive_pen.banco = vive_dep.banco AND vive_pen.monto = vive_dep.monto AND vive_dep.usuario = 'vacio'");
                    $stmt_ORDER->execute();
                    $stmt_ORDER->store_result();
                    $notifMatch = $stmt_ORDER->num_rows;
                    $stmt_ORDER->close();

                    $stmt_ORDER = $conn->prepare("SELECT id FROM vive_averia WHERE status='pendiente'");
                    $stmt_ORDER->execute();
                    $stmt_ORDER->store_result();
                    $notifAve = $stmt_ORDER->num_rows;
                    $stmt_ORDER->close();

                    $stmt_ORDER = $conn->prepare("SELECT id FROM vive_pen WHERE status='Pendiente'");
                    $stmt_ORDER->execute();
                    $stmt_ORDER->store_result();
                    $notifPen = $stmt_ORDER->num_rows;
                    $stmt_ORDER->close();

                    $notifTotal=$notifDev+$notifCamb+$notifAve+$notifPen;
                }

                if($user_logged['rol']=='Gerente'){
                    $stmt_ORDER = $conn->prepare("SELECT id FROM vive_usu_inf WHERE usuario=?");
                    $stmt_ORDER->bind_param('s', $buscarlogged);
                    $stmt_ORDER->execute();
                    $stmt_ORDER->store_result();
                    $notifNuevo = $stmt_ORDER->num_rows;
                    $stmt_ORDER->close();
                }

                $conn->close();

            }else{ ?>
            <style>
                header, main, footer { padding-left: 0px !important; }
            </style>
        <?php }
            if ( is_page('chat') ) {
                ?>
                    <style>
                        header, main, footer { padding-left: 0px !important; }
                    </style>
                <?php
            } ?>
	</head>
    <body ng-app="contactApp">
         <header>
                <div class="">
                    <nav id="site-navigation" class="main-navigation fondo6" role="navigation">
                        <div class="container-fluid">

                            <?php if ( is_user_logged_in() ) { ?>

                                <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>

                                <ul id="nav-mobile" class="left hide-on-med-and-down">
                                    <li>
                                        <a class="text-white"><i class="material-icons left">bookmark</i> <?php the_title(); ?></a>
                                    </li>
                                </ul>

                            <?php } ?>

                             <a href="#" class="brand-logo center white-text">
                                <img src="<?php echo get_bloginfo('template_directory');?>/img/logo.svg" class="responive-img" height="56px" width="auto">
                             </a>

                            <?php if ( is_user_logged_in() && !is_page('chat') ) { ?>

                                <ul id="nav-mobile" class="right hide-on-med-and-down">
                                    <li>
                                        <a class='efecto-zoom' href="<?php site_url(); ?>/mensajes/">
                                            <i class="material-icons">mail_outline</i>
                                            <span class="badge fondo3"><?php echo $msn; ?></span>
                                        </a>
                                    </li>
                                    <?php if($user_logged['rol']=='administrator'){ ?>
                                        <li>
                                            <a class='efecto-zoom' id="notificaciones" href="#navbar-notificaciones">
                                                <i class="material-icons">notifications_none</i>
                                                <span class="badge fondo3"><?php echo $notifTotal; ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <a class='dropdown-button' href='#' data-activates='dropdown1'><i class="material-icons">more_vert</i></a>
                                        <ul id='dropdown1' class='dropdown-content'>
                                            <li><a href="<?php site_url(); ?>/account/">PERFIL</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?php site_url(); ?>/logout/">LOG OUT</a></li>
                                        </ul>
                                    </li>
                                </ul>

                            <?php } ?>
                        </div>
                    </nav>
                </div>
                <?php
                if ( is_user_logged_in() && !is_page('chat') ) {

                    if($user_logged['rol']=='administrator'){
                        wp_nav_menu(
                        array( 'theme_location' => 'admin',
                        'menu_id' => 'slide-out',
                        'menu_class' => 'grey lighten-5 side-nav fixed',
                        'walker' => new Materialize_Walker_Desktop_Nav_Menu(),
                        'items_wrap' => '<ul id="%1$s" class="%2$s">
                                            <div class="side-nav-li-height">
                                                <li class="fondo6 sidenav-user-tab valign-wrapper paddingtop25 paddingbot25">
                                                    <a href="'.site_url().'/account/" class="valign">
                                                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 paddingleft0 paddingtop5 right-align">
                                                            '.$user_logged['avatarmd'].'
                                                        </div>
                                                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 left-align paddingleft0">
                                                            <b>'.$user_logged['login'].'</b> <br>
                                                            <span>'.$user_logged['nombre'].' '.$user_logged['apellido'].'</span> <br>
                                                            <i>'.$user_logged['email'].'</i> <br>
                                                            '.$user_logged['rol'].'
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="divider"></li>

                                                <li class="hide-on-large-only">
                                                    <a class="efecto-zoom" href="'.site_url().'/mensajes/">
                                                        <i class="material-icons">mail_outline</i>
                                                        MENSAJES
                                                        <span class="badge fondo3">'.$msn.'</span>
                                                    </a>
                                                </li>
                                                <li class="hide-on-large-only">
                                                    <a class="efecto-zoom" id="notificacionesxs" href="#navbar-notificaciones">
                                                        <i class="material-icons">notifications_none</i>
                                                        NOTIFICACIONES
                                                        <span class="badge fondo3">'.$notifTotal.'</span>
                                                    </a>
                                                </li>

                                                <li class="divider"></li>
                                                %3$s
                                            </div>
                                            <li class="fondo6 side-nav-settings center-align">
                                                <a class="efecto-zoom center-align" href="'.site_url().'/account/" id="side-nav-settings">
                                                    <i class="white-text small material-icons">&#xE8B8;</i>
                                                </a>
                                                <a class="efecto-zoom center-align" href="'.site_url().'/account/" id="side-nav-account">
                                                    <i class="white-text small material-icons">&#xE7FF;</i>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="clear"></div>' )
                        );
                    }
                    elseif($user_logged['rol']=='Gerente'){
                        wp_nav_menu(
                        array( 'theme_location' => 'gerente',
                        'menu_id' => 'slide-out',
                        'menu_class' => 'fondogris side-nav fixed',
                        'walker' => new Materialize_Walker_Desktop_Nav_Menu(),
                        'items_wrap' => '<ul id="%1$s" class="%2$s">
                                            <div class="side-nav-li-height">
                                                <li class="fondo6 sidenav-user-tab valign-wrapper paddingtop25 paddingbot25">
                                                    <a href="'.site_url().'/account/" class="">
                                                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 paddingleft0 paddingtop5 right-align">
                                                            '.$user_logged['avatarmd'].'
                                                        </div>
                                                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 left-align paddingleft0">
                                                            <b>'.$user_logged['login'].'</b> <br>
                                                            <span>'.$user_logged['nombre'].' '.$user_logged['apellido'].'</span> <br>
                                                            <i>'.$user_logged['email'].'</i> <br>
                                                            '.$user_logged['rol'].'
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="divider"></li>

                                                <li class="hide-on-large-only">
                                                    <a class="efecto-zoom" href="'.site_url().'/mensajes/">
                                                        <i class="material-icons">mail_outline</i>
                                                        MENSAJES
                                                        <span class="badge fondonaranja">'.$msn.'</span>
                                                    </a>
                                                </li>

                                                <li class="divider"></li>
                                                %3$s
                                            </div>
                                            <li class="fondo6 side-nav-settings center-align">
                                                <a class="efecto-zoom center-align" href="'.site_url().'/account/" id="side-nav-settings">
                                                    <i class="white-text small material-icons">&#xE8B8;</i>
                                                </a>
                                                <a class="efecto-zoom center-align" href="'.site_url().'/account/" id="side-nav-account">
                                                    <i class="white-text small material-icons">&#xE7FF;</i>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="clear"></div>' )
                        );
                    }
                    ?>

                <!--
                //////////////
                NOTIFICACIONES
                /////////////
                -->
                <div id="navbar-notificaciones" class="modal bottom-sheet">
                    <div class="modal-content">
                        <a class="black-text">
                            <ul class="collection">
                                <li class="collection-item avatar">
                                    <a href="<?php site_url(); ?>/depositos-problemas/" class="black-text"><i class="material-icons medium circle yellow darken-3">&#xE001;</i>
                                    <span class="title truncate"><b>DEPÓSITOS PROBLEMAS</b></span>
                                    <h4>Total: <b><?php echo $notifPen; ?></b></h4></a>
                                    <a href="<?php site_url(); ?>/comparacion/" class="black-text"><h4>Match: <b><?php echo $notifMatch; ?></b></h4></a>
                                </li>
                                <li class="collection-item avatar">
                                    <a href="<?php site_url(); ?>/cambios/" class="black-text"><i class="material-icons medium circle yellow darken-3">cached</i>
                                    <span class="title truncate"><b>CAMBIOS</b></span>
                                    <h4>Total: <b><?php echo $notifCamb; ?></b></h4></a>
                                </li>
                                <li class="collection-item avatar">
                                    <a href="<?php site_url(); ?>/averias/" class="black-text"><i class="material-icons medium circle yellow darken-3">build</i>
                                    <span class="title truncate"><b>AVERÍAS</b></span>
                                    <h4>Total: <b><?php echo $notifAve; ?></b></h4></a>
                                </li>
                                <li class="collection-item avatar">
                                    <a href="<?php site_url(); ?>/devoluciones/" class="black-text"><i class="material-icons medium circle yellow darken-3">arrow_back</i>
                                    <span class="title truncate"><b>DEVOLUCIONES</b></span>
                                    <h4>Total: <b><?php echo $notifDev; ?></b></h4></a>
                                </li>
                            </ul>
                        </a>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="fondo3 white-text modal-action modal-close waves-effect waves-green btn-flat"><i class="material-icons left">&#xE5CD;</i> CERRAR</a>
                    </div>
                </div>

                <?php
                }
                ?>

                </header>
		<main>
        <?php
        if ( is_user_logged_in() ) {
            if ( !is_page('chat') ) { ?>
                <div class="fixed-action-btn vertical">
                    <a class="btn-floating btn-large fondo3">
                        <i class="large material-icons fontsize24">add</i>
                    </a>
                    <?php
                        if($user_logged['rol']=='administrator'){
                            ?>
                            <ul>
                                <li><a class="btn-floating fondo2" href="<?php site_url(); ?>/buscar-deposito/"><i class="material-icons">search</i></a></li>
                                <li><a class="btn-floating fondo3" href="<?php site_url(); ?>/buscar-factura/"><i class="material-icons">credit_card</i></a></li>
                                <li><a class="btn-floating fondo4" href="<?php site_url(); ?>/mensajes/"><i class="material-icons">mail</i></a></li>
                            </ul>
                            <?php
                        } elseif($user_logged['rol']=='Gerente'){
                            ?>
                            <ul>
                                <li><a class="btn-floating fondo4" href="<?php site_url(); ?>/registrar-pago/"><i class="material-icons">credit_card</i></a></li>
                                <li><a class="btn-floating fondo2" href="<?php site_url(); ?>/registrar-deposito-problema/"><i class="material-icons">warning</i></a></li>
                                <li><a class="btn-floating fondo3" href="<?php site_url(); ?>/facturacion/"><i class="material-icons">view_list</i></a></li>
                                <li><a class="btn-floating fondo1" href="<?php site_url(); ?>/mensajes/"><i class="material-icons">mail</i></a></li>
                            </ul>
                            <?php
                        }
                    ?>
                </div>
        <?php }
        }
        /*
        if ( !is_page('account') ) {
            if($user_logged['rol']=='Gerente'){
                if($notifNuevo==0){
                    header("Location: http://app.vivecolecciones.com.ve/account/");
                    exit();
                }
            }
        }
        */
        ?>
