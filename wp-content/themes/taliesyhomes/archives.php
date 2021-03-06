<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>
<div id="main">
	<div id="content">
		<?php get_search_form(); ?>
		<h2>Archives by Month:</h2>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
		<h2>Archives by Subject:</h2>
		<ul>
			<?php wp_list_categories(); ?>
		</ul>
	</div>
	<!-- end content div -->
</div>
<!-- end main div -->
<?php get_footer(); ?>
