<?php get_header(); set_post_thumbnail_size(100, 100); ?>

<div id="container">
	<div id="content">
		<div class="grey-heading rounded">
			<div class="rounded-heading"><h2 class="entry-title"><?php single_cat_title(); ?></h2></div>
			<div class="rounded-content">		

				<?php while ( have_posts() ) : the_post() ?>

				<div id="post-<?php the_ID() ?>" class="news clearfix">
					<div class="news-image">
						<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'archive-thmb' ); ?></a>
					</div>
					<div class="news-content">	
						<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h3>
						<div class="news-date">
							<?php the_date(); ?>
						</div>
						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div>
					</div>					
					
				</div><!-- .news -->

				<?php endwhile; ?>
			</div>
			
		</div><!-- #grey rounded -->
    
    <br style="clear:both;" />

		</div><!-- #content -->
	</div><!-- #container -->
	
<?php get_footer(); ?>