<?php // clear after fourth post - gfh
$projects_row = ""; // reset var - gfh
if ( $i % 4 == 0 ) $projects_row =  " project-row";
$proj_type = get_post_meta($post->ID, 'plan_type', true);
$proj_community = get_post_meta($post->ID, 'community', true);
$proj_addr = get_post_meta($post->ID, "address", true);
$proj_city = get_post_meta($post->ID, "city", true);
$proj_lot = get_post_meta($post->ID, 'lot', true);
$proj_date = get_post_meta($post->ID, "completion_date", true);
$proj_price = get_post_meta($post->ID, 'price', true);
$proj_sqft = get_post_meta($post->ID, "sqft", true);
$proj_mls = get_post_meta($post->ID, "mls", true);
?>
				<div id="post-<?php the_ID() ?>" class="project<?php echo $projects_row; ?>">
					<div class="project-image">
						<a href="<?php the_permalink() ?>">								
							<?php 
								$image = get_the_post_thumbnail(); 
								if ($image){echo $image;}
								else {echo "<img src='".get_bloginfo('template_directory')."/images/icon-house.jpg' width='75' height='75'";}									
							?>															
						</a>
					</div>
					<div class="project-content">			
						<h3 class="project-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h3>
						<span class="project-plan"><?php echo $proj_type; ?></span>
						<span class="project-community"><?php echo $proj_community; ?> - Lot #<?php echo $proj_lot; ?></span>
						<?php if( !empty( $proj_price ) ) echo '<span class="project-price">' . $proj_price . '</span>'; ?>
						<div class="entry-content">
							<?php //echo "Build Status: ".get_post_meta($post->ID, 'completion_date', true); ?>		
						</div>
					</div>		
				</div>