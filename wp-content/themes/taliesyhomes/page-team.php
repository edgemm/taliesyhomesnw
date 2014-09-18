<?php /* Template Name: Category-Our Team */ ?>
<?php get_header();

// Custom Query to select posts in Our Team category
$args = array(
 	'post_type'		=> 'post',
	'cat'			=> $teamCat,
	'meta_key'		=> 'team_sort',
	'orderby'		=> 'meta_value',
	'order'			=> 'ASC',
	'posts_per_page'	=> 100
	);

$the_query = new WP_Query( $args );
global $post;
?>

<div id="container">
	<div id="content">
		<div class="grey-heading rounded">
			<div class="rounded-heading">
				<h2 class="entry-title"><?php the_title(); ?></h2>
				<ul class="tal-post-filters isotopeMenu">
					<li><a class="tal-post-filters-item " href="javascript:void(0)" data-filter="*">View All</a></li>
					<?php
				
					$cat_args = array(
						'child_of'	=> $teamCat,
						'hide_empty'	=> 0,
						'orderby'	=> 'name',
						'order'		=> 'ASC'
					);
					
					$categories = get_categories( $cat_args );
					
					foreach( $categories as $cats ) {
						$link_url = "javascript:void(0);";
						$item =	'<li><a class="tal-post-filters-item" href="' . $link_url . '" ';
				
						// take name, make all lowercase and turn all spaces into hyphens
						$item .= 'data-filter=".' . strtolower( $cats->category_nicename ) . '"';
						$item .= '>';
						$item .= $cats->cat_name;
						$item .= '</a></li>';
				
						echo $item;
					}
				
					?>
			
				</ul>
			</div>
			<div class="rounded-content isoContent">

				<?php // add MP isotope plugin to posts below
				//moveplugins_isotopes();
				?>

				<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
				<?php
					$member_title = get_post_meta($post->ID, 'team_title', true);
					
					// get all categories of post
					$categories = get_the_category();
					$catClass = ''; // store categories
			
					foreach( $categories as $postCats ) {
						$catClass .= " " . $postCats->category_nicename;
					}
					
					// get custom thumbnail for Team page view if specified - gfh
					$thumb_id = get_post_meta($post->ID, 'team_custom_thumbnail', true);
					$thmb_attr = array( 'class' => 'team-thmb' );
					$thumb = $thumb_id ? wp_get_attachment_image( $thumb_id, 'team-thmb', false, $thmb_attr ) : get_the_post_thumbnail( $post->ID, 'team-thmb', $thmb_attr );
					
					// get content and create excerpt - gfh
					$content = get_the_content();
					$content = ( strlen( $content ) > 165 ) ? substr($content, 0, 165) . '...' : $content;
					$content = closeTags( $content );
				?>
				<div id="post-<?php the_ID() ?>" class="team<?php echo $catClass; ?>">
					<a href="<?php the_permalink(); ?>"><?php echo $thumb; ?></a>
					<a href="<?php the_permalink(); ?>" class="team-title"><?php the_title(); ?><?php if ( $member_title ) echo " - " . $member_title; ?></a>
					<div class="team-desc"><?php echo $content; ?></div>
					<a href="<?php the_permalink(); ?>" class="team-more">Learn More</a>
				</div>

				<?php endwhile; wp_reset_query(); ?>
				<br style="clear:both;" />

			</div><!-- #rounded-content -->
						
		</div><!-- #grey rounded -->
  	<br style="clear:both;" />

	</div><!-- #content -->
</div><!-- #container -->
	
<?php get_footer(); ?>