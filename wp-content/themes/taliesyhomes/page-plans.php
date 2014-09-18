<?php /* Template Name: Category-Home Plans */ ?>
<?php get_header();
set_post_thumbnail_size(200, 135, true);

// Custom Query to Sort by Square Foot in the 'home-plans' section
$wpQuery = new WP_Query('post_type=home-plans&meta_key=sqft&orderby=meta_value&order=ASC&showposts=100');
global $post;
?>

<div id="container">
	<div id="content">
		<div class="grey-heading rounded">
			<div class="rounded-heading"><h2 class="entry-title"><?php the_title() ?></h2></div>
			<div class="rounded-content">

				<?php while ($wpQuery->have_posts()) : $wpQuery->the_post(); ?>

				<?php if ( !get_field('tal_archive_post') ) : ?>
				<div id="post-<?php the_ID() ?>">
					<div id="plan-image">
						<a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a><br />
						<strong><?php the_title() ?></strong>
						<?php echo "- ".get_post_meta($post->ID, 'sqft', true)." sf"; ?>
						<?php echo "<br />".get_post_meta($post->ID, 'rooms', true); ?>
						<br/><a href="<?php the_permalink() ?>">more information</a>
					</div>					
				</div><!-- .post -->
				<?php endif; ?>
				<?php endwhile; wp_reset_query(); ?>
				<br style="clear:both;" />

			</div><!-- #rounded-content -->
						
		</div><!-- #grey rounded -->
  	<br style="clear:both;" />

	</div><!-- #content -->
</div><!-- #container -->
	
<?php get_footer(); ?>