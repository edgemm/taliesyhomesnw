<?php get_header(); ?>

<div id="container">
	<div id="content">
		<div class="grey-heading rounded">
			
			<?php the_post() ?>
			
			<div id="post-<?php the_ID() ?>">
				<div class="rounded-heading"><h2 class="entry-title"><?php the_title() ?></h2></div>
				<div class="rounded-content entry-content">			
						<?php the_content(); ?>
				</div>
				
			</div><!-- .post -->			
		</div><!-- #grey rounded -->
    
    <br style="clear:both;" />

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_footer(); ?>
