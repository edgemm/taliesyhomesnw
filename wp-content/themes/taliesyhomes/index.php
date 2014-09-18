<?php get_header(); ?>

stuff


<div id="main">
	<div id="content">
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div <?php post_class(); ?>  id="post-<?php the_ID(); ?>">
			<!-- start post -->
			<div class="entry-date">
				<div class="entry-month">
					<?php the_time('M'); ?>
				</div>
				<div class="entry-day">
					<?php the_time('d'); ?>
				</div>
			</div>
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
				<?php the_title(); ?>
				</a></h2>
			<div class="entry-meta">By <?php the_author(); ?> Posted in <span class="catposted">
				<?php the_category(', ') ?>
				</span> <strong>|</strong> <span class="comments">
				<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
				</span> </div>
			<div class="entry-content">
				<?php the_content('Read the rest of this entry &raquo;'); ?>
				<?php edit_post_link('<img src="'. get_bloginfo('template_url') .'/images/pencil.png" alt="Edit Link" /> Edit this entry.', '<p>', '</p>'); ?>
			</div>
			<?php wp_link_pages();?>
		</div>
		<!-- end the post -->
		<?php endwhile; ?>
		<div class="navigation">
			<div class="alignleft">
				<?php next_posts_link('&laquo; Previous Entries') ?>
			</div>
			<div class="alignright">
				<?php previous_posts_link('Next Entries &raquo;') ?>
			</div>
		</div>
		<?php else : ?>
		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php get_search_form(); ?>
		<div class="navigation">
			<?php posts_nav_link();?>
		</div>
		<?php endif; ?>
	</div>
	<!-- end content -->
</div>
<!-- end main div -->
<?php get_footer(); ?>
