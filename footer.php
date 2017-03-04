	
		</main>
	<footer class="fondo6">
		<div class="footer">
            <div class="container-fluid">
                <div class="row marginbot0">
                    <div class="col-md-12">
                        <p class="copyright center-align small"> Todos los Derechos Reservados | Desarrollado por  <a href="http://bitcodeweb.com/" target="_blank"><img src="<?php echo get_bloginfo('template_directory');?>/img/logobitcodeb.svg" height="24px" width="auto" class="verticalalignbottom"></a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

	<?php wp_footer(); ?>
        <script>
             jQuery(document).ready(function(){
                jQuery(".button-collapse").sideNav();
                jQuery(".dropdown-button").dropdown({constrain_width: false,hover:true,belowOrigin: true, alignment: 'left', inDuration: 150, outDuration: 225, });
                jQuery('.modal').modal();
            });
        </script>
	</body>
</html>