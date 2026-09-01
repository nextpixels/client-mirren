<?php
get_header();	?>

		<div id="primary" class="content-area section-gray">

			<main id="main" class="site-main contain-1100 p-mobile-1150" style="min-height: 900px;">

				<div class="padding-b-100">
					<?php
					while ( have_posts() ) :
						the_post();	?>
						
						<?php
			

						get_template_part( 'template-parts/content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>
				</div>
			</main><!-- #main -->
		</div><!-- #primary --><?php
		
	get_footer();
?>