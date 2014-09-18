<?php /* Template Name: OurTeam */ ?>
<?php get_header(); ?>
<?php  global $post; ?>
<?php if($post->post_parent) {$parent_title = get_the_title($post->post_parent);} ?>

<div id="container">
	<div id="content">
		<div class="grey-heading rounded">
			
			<?php the_post() ?>
			
			<div id="post-<?php the_ID() ?>">
				<div class="rounded-heading"><h2 class="entry-title"><?php the_title() ?></h2></div>
				<div class="rounded-content entry-content">			
			
					<div id="submenu">
						<ul>
							<li><a href="<?php bloginfo('url'); ?>/our-team/" <?php if ($post->ID == 129){echo "id='selected'";} ?>>Meet the Builder</a></li>
							<li><a href="<?php bloginfo('url'); ?>/our-team/realtors" <?php if ($post->ID == 174){echo "id='selected'";} ?>>Realtors</a></li>
							<li><a href="<?php bloginfo('url'); ?>/our-team/financing" <?php if ($post->ID == 137){echo "id='selected'";} ?>>Financing</a></li>
							<li><a href="<?php bloginfo('url'); ?>/our-team/contact-us" <?php if ($post->ID == 138){echo "id='selected'";} ?>>Contact Us</a></li>
						</ul>
					</div>
					<div id="content">
						<?php the_content(); ?>
					</div>			
					<div style="clear:both;"></div>
						
				</div>
				
			</div><!-- .post -->			
		</div><!-- #grey rounded -->
    
    <br style="clear:both;" />

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_footer(); ?>