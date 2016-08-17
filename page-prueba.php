<?php get_header();
	include (TEMPLATEPATH . '/funciones/usuariologged.php');
	?>
    <div class="container">
		<div class="chip">
			<?php echo $usuariologged; echo $grvimg; ?>
		</div>
	</div>
<?php get_footer(); ?>