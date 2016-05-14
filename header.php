<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <title> Vive</title>
        <link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_directory');?>/img/favicon.ico">
		<?php wp_head(); ?>
        <meta name="robots" content="NOFOLLOW, NOINDEX">
	</head>
	<body>
    <?php if ( is_user_logged_in() ) { $current_user = wp_get_current_user(); $usuariologged = $current_user->user_login; ?>
        <nav class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-brand">
                        <a class="" href="#" rel="canonical"><img src="<?php echo get_bloginfo('template_directory');?>/img/logonav.jpg" class="marginauto img-responsive"></a>
                    </div>                      
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <?php 
                        if( current_user_can('administrator')) { 
                            wp_nav_menu(array( 'theme_location' => 'admin', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-right', 'walker' => new Bootstrap_Walker_Nav_Menu() ) ); 
                        } 
                        elseif( current_user_can('subscriber')) {
                            wp_nav_menu(array( 'theme_location' => 'user', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-right', 'walker' => new Bootstrap_Walker_Nav_Menu() ) );
                        } 
                    ?>
                </div>
            </div>
        </nav>
        <div class="container hidden-print"><h4 class="text-right">Usuario: <?php echo $usuariologged ?></h4></div>
<?php } else { ?>
    <div class="container paddingtop75 paddingbot75">
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="http://vive.bitcodeweb.com/"><img src="<?php echo get_bloginfo('template_directory');?>/img/logo.jpg" class="marginauto img-responsive"></a>
            </div>
        </div>
    </div>
<?php } ?>
