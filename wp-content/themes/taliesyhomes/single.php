<?php get_header(); ?>
<?php
$category = get_the_category();
$parent = get_cat_name($category[0]->category_parent);
?>

<div id="container">
	<div id="content">
		<div class="grey-heading rounded">
			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<?php
			if( in_category( $teamCat ) || post_is_in_descendant_category( $teamCat ) ) : // if in Our Team category or child category of Our Team - gfh
				include(locate_template('single-team.php'));
			else :
			?>
			
			<div id="post-<?php the_ID() ?>">
				<div class="rounded-heading"><h2 class="entry-title"><?php echo $category[0]->name." : <span id='sub'>".get_the_title() ?></span></h2></div>
				<div class="rounded-content entry-content">
					<div id="facebook"><?php if(function_exists("SFBSB_direct")) {echo SFBSB_direct("button");} ?></div>
						<?php the_content(); ?>
						
						<?php echo get_post_meta($post->ID, 'designers', true); ?>
						
						<?php if (get_post_meta($post->ID, 'news-gallery', true) != ""){?>
							<h3>Images:</h3>
							<?php echo apply_filters('the_content', '[nggallery id='.get_post_meta($post->ID, 'news-gallery', true).' template=photos]'); ?>
						<?php } ?>
						
				</div>				
			</div><!-- .post -->

			<?php endif; ?>

		<?php endwhile; else: ?>
			<p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>
					
		</div><!-- #grey rounded -->
    
    <br style="clear:both;" />

		</div><!-- #content -->
	</div><!-- #container -->
	
<?php get_footer(); ?>