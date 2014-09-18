<?php get_header(); ?>
<?php set_post_thumbnail_size(360, 270); ?>

<div id="container">
	<div id="content">
		<div class="grey-heading rounded">
			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php
			
			$proj_type = get_post_meta($post->ID, 'plan_type', true);
			$proj_community = get_post_meta($post->ID, 'community', true);
			$proj_addr = get_post_meta($post->ID, "address", true);
			$proj_city = get_post_meta($post->ID, "city", true);
			$proj_lot = get_post_meta($post->ID, 'lot', true);
			$proj_price = get_post_meta($post->ID, 'price', true);
			$proj_sqft = get_post_meta($post->ID, "sqft", true);
			$proj_mls = get_post_meta($post->ID, "mls", true);
			$proj_status = get_post_meta($post->ID, 'completion_date', true);
			?>
			
			<div id="post-<?php the_ID() ?>">
				<div class="rounded-heading"><h2 class="entry-title">Current Projects : <span id='sub'><?php the_title(); ?></span></h2></div>
				<div class="rounded-content entry-content">

					<div id="project-info">
						<div id="plan-left"><?php the_post_thumbnail(); ?></div>
						<div id="plan-right">
							<?php if( !empty( $proj_type ) ) { ?><span class="proj-info"><span class="proj-info-title">Plan Type: </span><?php echo $proj_type; ?></span><?php } ?>
							<?php if( !empty( $proj_community ) ) { ?><span class="proj-info"><span class="proj-info-title">Community: </span><?php echo $proj_community; ?></span><?php } ?>
							<?php if( !empty( $proj_lot ) ) { ?><span class="proj-info"><span class="proj-info-title">Lot: </span><?php echo $proj_lot; ?></span><?php } ?>
							<?php if( !empty( $proj_addr ) ) { ?><span class="proj-info"><span class="proj-info-title">Address: </span><?php echo $proj_addr; ?></span><?php } ?>
							<?php if( !empty( $proj_city ) ) { ?><span class="proj-info"><span class="proj-info-title">City: </span><?php echo $proj_city; ?></span><?php } ?>
							<?php if( !empty( $proj_sqft ) ) { ?><span class="proj-info"><span class="proj-info-title">Sqft: </span><?php echo $proj_sqft; ?></span><?php } ?>
							<?php if( !empty( $proj_price ) ) { ?><span class="proj-info"><span class="proj-info-title">Price: </span><?php echo $proj_price; ?></span><?php } ?>
							<?php if( !empty( $proj_mls ) ) { ?><span class="proj-info"><span class="proj-info-title">MLS #: </span><?php echo $proj_mls; ?></span><?php } ?>
							<?php if( !empty( $proj_status ) ) { ?><span class="proj-info"><span class="proj-info-title">Status: </span><?php echo $proj_status; ?></span><?php } ?>
						</div>
					</div>					
					<div style="clear:both;"></div>
					<?php if (get_post_meta($post->ID, 'gallery_id', true) != ""){ ?>
						<div id="project-photos">
							<h2>View Project Photos</h2>
							<?php echo apply_filters('the_content', '[nggallery id='.get_post_meta($post->ID, 'gallery_id', true).']'); ?>
						</div>
						<?php } ?>
						
				</div>				
			</div><!-- .post -->	

		<?php endwhile; else: ?>
			<p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>
					
		</div><!-- #grey rounded -->
    
    <br style="clear:both;" />

		</div><!-- #content -->
	</div><!-- #container -->
	
<?php get_footer(); ?>