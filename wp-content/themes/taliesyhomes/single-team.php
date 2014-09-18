<?php
// get parent category for breadcrumbs - gfh
$category = get_the_category();
$parent = get_cat_name($category[0]->category_parent);
$cat_name = $category[0]->name;
$cat_slug = $category[0]->slug;

// url for team page - gfh
$team_page = "/our-team/";
$iso_item_class = "tal-post-filters-item noIso";
?>


<div id="post-<?php the_ID() ?>">
	<div class="rounded-heading">
		<h2 class="entry-title"><?php echo get_cat_name( $teamCat ); ?></span></h2>
		<ul class="tal-post-filters isotopeMenu">
			<li><a class="<?php echo $iso_item_class; ?>" href="<?php echo $team_page; ?>" data-filter="*">View All</a></li>
			<?php
		
			$cat_args = array(
				'child_of'	=> $teamCat,
				'hide_empty'	=> 0,
				'orderby'	=> 'name',
				'order'		=> 'ASC'
			);
			
			$categories = get_categories( $cat_args );
			
			foreach( $categories as $cats ) {
				$item =	'<li><a class="' . $iso_item_class . '" href="' . $team_page . '?t=' . $cats->slug . '" ';
		
				// take name, make all lowercase and turn all spaces into hyphens
				$item .= 'data-filter=".' . strtolower( $cats->slug ) . '"';
				$item .= '>';
				$item .= $cats->cat_name;
				$item .= '</a></li>';

				echo $item;
			}
		
			?>
	
		</ul>
	</div>
	<div class="rounded-content entry-content">
		<?php 
		?>
		<ul class="breadcrumbs">
			<li class="breadcrumbs-item"><a class="breadcrumbs-link" href="/meet-our-team/">Our Team</a></li>
			<li class="breadcrumbs-item"><a class="breadcrumbs-link" href="/meet-our-team/?t=<?php echo $cat_slug; ?>"><?php echo $cat_name; ?></a></li>
			<li class="breadcrumbs-item breadcrumbs-current"><?php the_title(); ?></li>
		</ul>
		<div class="member">

			<?php // individual information for member - gfh
				$m_title = get_post_meta($post->ID, 'team_title', true);
				$m_company_img = wp_get_attachment_image( get_post_meta($post->ID, 'team_company_logo', true), 'team-company', false, array( 'class' => 'member-company-thmb' ) );
				$m_phone = get_post_meta($post->ID, 'team_phone', true);
				$m_email = get_post_meta($post->ID, 'team_email', true);
				//$m_company_name = get_post_meta($post->ID, 'team_company_name', true);
				//$m_cell = get_post_meta($post->ID, 'team_cellphone', true);
				//$m_addr = get_post_meta($post->ID, 'team_address', true);
				//$m_site = get_post_meta($post->ID, 'team_website', true);
				//$m_efax = get_post_meta($post->ID, 'team_efax', true);
				//$m_ex_title_01 = get_post_meta($post->ID, 'team_extra_title_01', true);
				//$m_ex_val_01 = get_post_meta($post->ID, 'team_extra_value_01', true);
				//$m_ex_title_02 = get_post_meta($post->ID, 'team_extra_title_02', true);
				//$m_ex_val_02 = get_post_meta($post->ID, 'team_extra_value_02', true);
				//$m_ex_title_03 = get_post_meta($post->ID, 'team_extra_title_03', true);
				//$m_ex_val_03 = get_post_meta($post->ID, 'team_extra_value_03', true);
			?>

			<?php if ( has_post_thumbnail() ) { // add .member-thmb only if there is a thumbnail ?>
			<div class="member-thmb">
				<?php the_post_thumbnail( "team-full", array( 'class' => 'member-thmb-img') ); ?>
				<?php if( $m_company_img ) echo $m_company_img; ?>
			</div>
			<?php } ?>
			<div class="member-entry">
				<h1 class="member-name"><?php the_title(); ?></h1>
				<?php
				if( $m_title ) echo '<span class="member-title">' . $m_title . '</span>';
				if( $m_phone ) echo '<span class="member-phone">' . $m_phone . '</span>';
				if( $m_email ) echo '<span class="member-email"><a class="member-email-link" href="mailto:' . $m_email . '">' . $m_email . '</a></span>';
				?>
				<?php the_content(); ?>
			</div>
		</div>
	</div>				
</div><!-- .post -->