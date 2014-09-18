<?php get_header(); ?>
<?php set_post_thumbnail_size(250, 250); ?>


<div id="container">
	<div id="content">
		<div class="grey-heading rounded">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<div id="post-<?php the_ID() ?>">
				<div class="rounded-heading"><h2 class="entry-title">Neighborhoods : <span id='sub'><?php the_title(); ?></span></h2></div>
				<div class="rounded-content entry-content">											
					<div id="community-left">
						<?php the_post_thumbnail(); ?>
						
						<?php if (get_post_meta($post->ID, 'price', true) != ""){ ?>
							<p><h3>PRICE:</h3>
							<?php echo get_post_meta($post->ID, 'price', true); ?></p>
						<?php } ?>
						
						<p><h3>SUMMARY:</h3>
						<?php the_content(); ?></p>
					
						<?php if (get_post_meta($post->ID, 'model-home', true) != ""){ ?>
							<p><h3>MODEL HOME LOCATION:</h3>
							<?php echo get_post_meta($post->ID, 'model-home', true); ?></p>
						<?php } ?>
						
						<?php if (get_post_meta($post->ID, 'directions', true) != ""){ ?>						
							<p><h3>DIRECTIONS:</h3>
							<?php echo get_post_meta($post->ID, 'directions', true); ?></p>
						<?php } ?>
						
						<?php if (get_post_meta($post->ID, 'contact', true) != ""){ ?>	
							<p><h3>CONTACT INFO:</h3>
							<?php echo get_post_meta($post->ID, 'contact', true); ?></p>
						<?php } ?>
						
						<?php if (get_post_meta($post->ID, 'highlights', true) != ""){ ?>
							<p><h3>COMMUNITY HIGHLIGHTS:</h3>
							<?php echo get_post_meta($post->ID, 'highlights', true); ?></p>
						<?php } ?>
						
						<?php if (get_post_meta($post->ID, 'availability', true) != ""){ ?>
							<p><h3>AVAILABILITY:</h3>
							<?php echo get_post_meta($post->ID, 'availability', true); ?></p>
						<?php } ?>
					
					
					</div>
					<div id="community-right">
						<?php if (get_post_meta($post->ID, 'google_map', true) != ""){ ?>
							<p><h3>GOOGLE MAP:</h3>
							<?php echo get_post_meta($post->ID, 'google_map', true); ?></p>
						<?php } ?>

						<?php if (get_post_meta($post->ID, 'plat_map', true) != ""){ ?>						
							<p><h3>PLAT MAP:</h3>
							<a href="<?php echo bloginfo('url')."/wp-content/uploads/".get_post_meta($post->ID, 'plat_map', true); ?>"><img src="<?php echo bloginfo('url')."/wp-content/uploads/".get_post_meta($post->ID, 'plat_map', true); ?>" height="200px" class="colorbox-001" title="Plat Map: <?php the_title(); ?>"></a></p>
						<?php } ?>
					
					</div>
					<div style="clear:both;"></div>
					
					<?php $photos = get_post_meta($post->ID, 'gallery-photos', true);
						if ($photos) { ?>
							<h3 style="color:#FF9933;">MODEL HOME PHOTOS</h3>
							<?php echo apply_filters('the_content', '[nggallery id='.$photos.' template=photos]'); ?>
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