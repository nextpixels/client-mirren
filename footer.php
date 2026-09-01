<?php
	require_once(get_template_directory()."/functions/ergo-include-section.php");  
?>

		</div><!-- #page-contain -->
	</div><!-- #content -->
		
	<?php 
	ergo_include_section("/elements/footer");
	?>

</div><!-- #page -->

<?php wp_footer(); ?>

<?php
if (file_exists(get_stylesheet_directory()."/inc-footer-bottom.php")){
	require_once(get_stylesheet_directory()."/inc-footer-bottom.php"); 
}
?>

</body>
</html>