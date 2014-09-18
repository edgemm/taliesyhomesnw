<?php get_header(); ?>
<?php set_post_thumbnail_size(360, 270); ?>

<div id="container">
	<div id="content">
		<div class="grey-heading rounded">
			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<div id="post-<?php the_ID() ?>">
				<div class="rounded-heading"><h2 class="entry-title">Available Home Plans : <span id='sub'><?php the_title(); ?></span></h2></div>
				<div class="rounded-content entry-content">
					<div id="plan-left"><?php the_post_thumbnail(); ?></div>
					<div id="plan-right">
						<div id="top"><h3>Plan Specs:</h3>
							<p>
							<?php $sqft = get_post_meta($post->ID, 'sqfoot', true); if ($sqft){ echo $sqft." sf / ";} ?>
							<?php $rooms = get_post_meta($post->ID, 'rooms', true); if ($rooms){ echo $rooms." / ";} ?>
							<?php $garage = get_post_meta($post->ID, 'garage', true); if ($garage){ echo $garage;} ?>
							</p>
						</div>
						<div id="middle">
								<div id="left"><h3>Standard Features:</h3>
									<ul>
										<li>Granite Kitchen Counters</li>
										<li>Custom Alder Cabinets</li>
										<li>Designer High Grade Carpet</li>
										<li>Stainless Gas Appliances</li>
										<li>Fully Finished Garage</li>
									</ul>									
									</div>
								<div id="right"><h3>Available Upgrades:</h3>
									<ul>
										<li>Air Conditioning</li>
										<li>Central Vacuum System</li>
										<li>Fencing</li>
										<li>Rear Yard Landscaping</li>
										<li>Washer / Dryer</li>
									</ul>																												
									</div>
						</div>
						<div id="bottom">
							<div id="left">				
								<h3>Floor Plans:</h3>
								<?php echo apply_filters('the_content', '[nggallery id='.get_post_meta($post->ID, 'gallery-plans', true).' template=plans]'); ?>
							</div>
							<div id="right">
								<ul><li><a href="<?php bloginfo('url'); ?>/interactive-builder/step2/?plan=<?php echo $post->ID; ?>"><img src="<?php bloginfo('template_directory') ?>/images/btn-buildThisHome.png"></a></li>
									  <li><?php $pdf = get_post_meta($post->ID, 'pdf-flyer', true); if ($pdf){?><a href="<?php echo get_bloginfo('url')."/wp-content/uploads/".$pdf; ?>" target="_blank" onClick="_gaq.push(['_trackEvent', 'Flyer', 'Download', 'Home Flyer']);"><img src="<?php bloginfo('template_directory') ?>/images/btn-downloadFlyer.png"></a></li><?php } ?>
									</ul>
							</div>
						</div>
					</div>
					<br style="clear:both;" />
					<div id="plan-content">
						<?php the_content(); ?>
						<?php
						$ataShow = get_post_meta($post->ID, 'show_addtoany', true);
						if ( $ataShow ) echo do_shortcode( '[addtoany]' );
						?>	
					</div>
					
					<?php $photos = get_post_meta($post->ID, 'gallery-photos', true); if ($photos){ ?>
					<div id="plan-photos">
					<h3>View Photos</h3>	
  				<?php echo apply_filters('the_content', '[nggallery id='.$photos.' template=photos]'); ?>
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