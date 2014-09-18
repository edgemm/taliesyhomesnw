<?php /* Template Name: Category-Neighborhood */ ?>
<?php get_header();
set_post_thumbnail_size(200, 200);

// Custom Query to Sort by Price in the 'neighborhoods' section
$wpQuery = new WP_Query('post_type=neighborhoods&meta_key=map_id&orderby=meta_value&order=ASC&showposts=20');
global $post;
?>

<div id="container">
	<div id="content">
		<div class="grey-heading rounded">
			<div class="rounded-heading"><h2 class="entry-title"><?php the_title() ?></h2></div>
			<div class="rounded-content">

				<img id="map" src="<?php bloginfo('template_directory') ?>/images/taliesy_neighborhoods_map.jpg" usemap="#Map" border="0">
				<map name="Map" id="Map">
					<area id="1" shape="circle" alt="" title="" coords="482,212,22" href="sunrise-heights/" target="" />
					<area id="2" shape="circle" alt="" title="" coords="433,346,23" href="wenzel-park" target="" />
					<area id="3" shape="circle" alt="" title="" coords="420,96,23" href="southern-ridge" target="" />
					<area id="4" shape="circle" alt="" title="" coords="419,287,23" href="pfeifer-ridge" target="" />
					<area id="7" shape="circle" alt="" title="" coords="519,158,22" href="sunrise-mountain-view" target="" />
					<area id="8" shape="circle" alt="" title="" coords="235,263,22" href="cavalier-meadows" target="" />
					<area id="9" shape="circle" alt="" title="" coords="343,43,23" href="black-horse-estates" target="" />
					<area id="10" shape="circle" alt="" title="" coords="79,51,22" href="volare-townhomes" target="" />
					<area id="11" shape="circle" alt="" title="" coords="828,45,22" href="meriwether" target="" />
					<area id="12" shape="circle" alt="" title="" coords="727,310,23" href="brookside" target="" />
				</map>					

				<?php while ($wpQuery->have_posts()) : $wpQuery->the_post(); ?>

				<?php if ( !get_field('tal_archive_post') ) : ?>
				
				<div id="post-<?php the_ID() ?>">
					<div id="community">
						<div id="image">
							<a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a><br />
						</div>
						<div id="content">	
							<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php echo get_post_meta($post->ID, 'map_id', true).") ".get_the_title()." - ".get_post_meta($post->ID, 'city', true); ?></a></h3>
							<div class="entry-content">
								<?php the_excerpt(); ?>			
							</div>
						</div>
					</div>
					<br style="clear:both;" />
				</div>
				<?php endif; // end if is not archived - gfh ?>
				<?php endwhile; wp_reset_query(); ?>
				
					
			</div><!-- #rounded-content -->			
		</div><!-- #grey rounded -->
    <br style="clear:both;" />

	</div><!-- #content -->
</div><!-- #container -->
	
<?php get_footer(); ?>