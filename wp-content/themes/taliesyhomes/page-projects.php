<?php /* Template Name: Category-Projects */ ?>
<?php get_header();
set_post_thumbnail_size(181, 137);

// show all posts unless var changed - gfh
$posts_show = -1;

// array containing different types and values for each - gfh
$types = array(
	'move-in-ready' => array(
		'title' =>	'Move-In Ready',
		'type' =>	'move-in ready',
		'url' =>	'move-in-ready/'
	),
	'under-construction' => array(
		'title' =>	'Under Construction',
		'type' =>	'under construction',
		'url' =>	'under-construction/'
	),
	'completed' => array(
		'title' =>	'Completed',
		'type' =>	'completed',
		'url' =>	'completed/'
	)
);

// determines if page is main projects page or for specific project type - gfh
$url = explode("/", $_SERVER["REQUEST_URI"]);

if ( isset( $url[3] ) ) { // determines if page is specific project type or main projects page - gfh
	$type = $types[$url[2]]; // set $type to array containing values for project type - gfh
} else {
	$posts_show = 4; // show fewer posts if is main projects page - gfh
}
?>

<div id="container" class="projects-container" data-testitle="title is: <?php echo $testaroo['url']; ?>">
	<div id="content">
		<div class="grey-heading rounded">
			<?php // run only once if specific project type page, returning all results - gfh
			if( isset( $type['type'] ) ) {
				
				// Custom Query to Sort by Price in the 'current-projects' section
				$args = array(
					'post_type' =>		'current-projects',
					'meta_key' =>		'completion_date',
					'meta_value' =>		$type['type'],
					'posts_per_page' =>	$posts_show
				);
				
				//$wpQuery = new WP_Query('post_type=current-projects&meta_key=completion_date&meta_value=under construction&showposts=4');
				$wpQuery = new WP_Query( $args );
				global $post;
				
				// var for clearing for new row - gfh
				$i = 0;
			?>
			<div class="rounded-heading clearfix">
				<h2 class="entry-title"><?php echo $type['title']; ?></h2>
			</div>
			<div class="rounded-content clearfix">
				<?php while ($wpQuery->have_posts()) : $wpQuery->the_post(); ?>

				<?php if ( !get_field('tal_archive_post') ) : ?>

				<?php include(locate_template('/templates/content-projects.php')) ?>
				<?php $i++; ?>

				<?php endif; // end if is not archived - gfh ?>
				<?php endwhile; wp_reset_query(); ?>


			</div><!-- #rounded-content -->
			<?php } else { ?>
			<? // run for each object in array containing types of projects - gfh
				$c = 0; // set count of times loop has run - gfh
				foreach($types as $t) {
				if( $t['type'] != "move-in ready" ) {
				$heading_class = ( $c < 1 ? "rounded-" : "" ); // sets class to only round first heading - gfh
			?>
			<div class="<?php echo $heading_class; ?>heading clearfix">
				<h2 class="entry-title"><?php echo $t['title']; ?></h2>
				<a class="projects-more" href="<?php echo site_url( '/projects/' . $t['url'] ); ?>" title="See more <?php echo $t['title']; ?> projects...">View More &raquo;</a>
			</div>
			<div class="rounded-content clearfix">
				<?php
				
				// Custom Query to Sort by Price in the 'current-projects' section
				$args = array(
					'post_type' =>		'current-projects',
					'meta_key' =>		'completion_date',
					'meta_value' =>		$t['type'],
					'posts_per_page' =>	$posts_show
				);

				//$wpQuery = new WP_Query('post_type=current-projects&meta_key=completion_date&meta_value=under construction&showposts=4');
				$wpQuery = new WP_Query( $args );
				global $post;
				$i = 0;

				while ($wpQuery->have_posts()) : $wpQuery->the_post();

				include(locate_template('templates/content-projects.php'));
				$i++;
				?>

				<?php endwhile; wp_reset_query(); ?>


			</div><!-- #rounded-content -->
			<?php } // end if not move in ready ?>
			<?php } // end foreach ?>
			<?php } // end else ?>
		</div><!-- #grey rounded -->
  	<br style="clear:both;" />

	</div><!-- #content -->
</div><!-- #container -->
	
<?php get_footer(); ?>